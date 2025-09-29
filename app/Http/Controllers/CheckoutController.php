<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $selectedItems = [];
        
        if ($request->has('items')) {
            $itemIds = explode(',', $request->get('items'));
            $selectedItems = Cart::with('product.images')
                ->whereIn('id', $itemIds)
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $selectedItems = Cart::with('product.images')
                ->where('user_id', Auth::id())
                ->get();
        }

        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item yang dipilih untuk checkout');
        }

        // Get user addresses
        $userAddresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $defaultAddress = $userAddresses->where('is_default', true)->first();

        // Calculate totals
        $subtotal = $selectedItems->sum(function ($item) {
            return ($item->product->harga_jual ?? $item->product->harga) * $item->kuantitas;
        });

        // Calculate total weight from cart items
        $totalWeight = $selectedItems->sum(function ($item) {
            return ($item->product->berat ?? 1000) * $item->kuantitas; // Default 1000g if no weight
        });

        $tax = $subtotal * 0.025;
        
        // Initial shipping will be calculated dynamically by RajaOngkir
        $shipping = 0; 
        $total = $subtotal + $tax + $shipping;

        return view('checkout', compact(
            'selectedItems', 
            'subtotal', 
            'tax', 
            'shipping', 
            'total', 
            'userAddresses', 
            'defaultAddress',
            'totalWeight'
        ));
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'items' => 'required|string',
            'selected_address' => 'required',
            'shipping_name' => 'required_if:selected_address,manual|string|max:255',
            'shipping_email' => 'required_if:selected_address,manual|email|max:255',
            'shipping_phone' => 'required_if:selected_address,manual|string|max:20',
            'shipping_address' => 'required_if:selected_address,manual|string',
            'shipping_city' => 'required_if:selected_address,manual|string|max:255',
            'shipping_province' => 'required_if:selected_address,manual|string|max:255',
            'shipping_postal_code' => 'required_if:selected_address,manual|string|max:10',
            'shipping_district_id' => 'required|integer', // RajaOngkir district ID
            'courier_code' => 'required|string', // JNE, TIKI, POS, etc
            'courier_service' => 'required|string', // REG, YES, OKE, etc
            'shipping_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'same_as_shipping' => 'nullable|boolean',
        ]);

        if (!$request->same_as_shipping) {
            $request->validate([
                'billing_name' => 'required|string|max:255',
                'billing_email' => 'required|email|max:255',
                'billing_phone' => 'required|string|max:20',
                'billing_address' => 'required|string',
                'billing_city' => 'required|string|max:255',
                'billing_province' => 'required|string|max:255',
                'billing_postal_code' => 'required|string|max:10',
            ]);
        }

        try {
            $itemIds = explode(',', $request->items);
            $cartItems = Cart::with('product')
                ->whereIn('id', $itemIds)
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Tidak ada item yang valid untuk checkout');
            }

            // Check stock availability
            foreach ($cartItems as $item) {
                if ($item->product->stock_kuantitas < $item->kuantitas) {
                    throw new \Exception("Stok {$item->product->name} tidak mencukupi");
                }
            }

            // Get shipping address data
            $selectedAddressId = null;
            $shippingData = [];
            
            if ($request->selected_address !== 'manual') {
                $selectedAddressId = $request->selected_address;
                $address = UserAddress::where('id', $selectedAddressId)
                    ->where('user_id', Auth::id())
                    ->first();
                
                if (!$address) {
                    throw new \Exception('Selected address not found');
                }
                
                $shippingData = [
                    'name' => $address->recipient_name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '',
                    'address' => $address->address,
                    'city' => $address->city,
                    'province' => $address->province,
                    'postal_code' => $address->postal_code,
                    'district_id' => $request->shipping_district_id,
                ];
            } else {
                $shippingData = [
                    'name' => $request->shipping_name,
                    'email' => $request->shipping_email,
                    'phone' => $request->shipping_phone,
                    'address' => $request->shipping_address,
                    'city' => $request->shipping_city,
                    'province' => $request->shipping_province,
                    'postal_code' => $request->shipping_postal_code,
                    'district_id' => $request->shipping_district_id,
                ];
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return ($item->product->harga_jual ?? $item->product->harga) * $item->kuantitas;
            });

            $tax = $subtotal * 0.025;
            $shippingCost = $request->shipping_cost; // From RajaOngkir
            $grandTotal = $subtotal + $tax + $shippingCost;

            $orderNumber = 'TEMP-' . time() . '-' . Auth::id();
            
            // Create order data for payment
            $orderData = [
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'total' => $grandTotal,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'courier_code' => $request->courier_code,
                'courier_service' => $request->courier_service,
                'items' => $cartItems,
                'selected_address_id' => $selectedAddressId,
                'customer' => [
                    'name' => $shippingData['name'],
                    'email' => $shippingData['email'],
                    'phone' => $shippingData['phone'],
                ],
                'shipping' => $shippingData,
                'billing' => !$request->same_as_shipping ? [
                    'name' => $request->billing_name,
                    'email' => $request->billing_email,
                    'phone' => $request->billing_phone,
                    'address' => $request->billing_address,
                    'city' => $request->billing_city,
                    'province' => $request->billing_province,
                    'postal_code' => $request->billing_postal_code,
                ] : $shippingData,
                'notes' => $request->notes,
            ];

            $snapToken = $this->midtransService->createSnapTokenFromData($orderData);
            session(['pending_order_data' => $orderData]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_number' => $orderNumber
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'transaction_id' => 'required|string',
        ]);

        try {
            $orderData = session('pending_order_data');
            if (!$orderData) {
                throw new \Exception('Order data not found');
            }

            $transactionStatus = $this->midtransService->getTransactionStatus($request->transaction_id);
            $status = is_object($transactionStatus) ? $transactionStatus->transaction_status : $transactionStatus['transaction_status'];
            
            if (!in_array($status, ['capture', 'settlement'])) {
                throw new \Exception('Payment not completed');
            }

            DB::beginTransaction();

            $itemIds = $orderData['items']->pluck('id');
            $cartItems = Cart::with('product')
                ->whereIn('id', $itemIds)
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart items no longer available');
            }

            $realOrderNumber = Order::generateOrderNumber();

            $order = Order::create([
                'order_number' => $realOrderNumber,
                'user_id' => Auth::id(),
                'address_id' => $orderData['selected_address_id'],
                'status' => 'processing',
                'subtotal' => $orderData['subtotal'],
                'tax' => $orderData['tax'],
                'total' => $orderData['total'],
                'total_amount' => $orderData['subtotal'],
                'shipping_cost' => $orderData['shipping_cost'],
                'grand_total' => $orderData['total'],
                'courier_code' => $orderData['courier_code'],
                'courier_service' => $orderData['courier_service'],
                'shipping_name' => $orderData['shipping']['name'],
                'shipping_email' => $orderData['shipping']['email'],
                'shipping_phone' => $orderData['shipping']['phone'],
                'shipping_address' => $orderData['shipping']['address'],
                'shipping_city' => $orderData['shipping']['city'],
                'shipping_province' => $orderData['shipping']['province'],
                'shipping_postal_code' => $orderData['shipping']['postal_code'],
                'shipping_district_id' => $orderData['shipping']['district_id'] ?? null,
                'billing_name' => $orderData['billing']['name'],
                'billing_email' => $orderData['billing']['email'],
                'billing_phone' => $orderData['billing']['phone'],
                'billing_address' => $orderData['billing']['address'],
                'billing_city' => $orderData['billing']['city'],
                'billing_province' => $orderData['billing']['province'],
                'billing_postal_code' => $orderData['billing']['postal_code'],
                'payment_method' => 'midtrans',
                'payment_status' => 'paid',
                'payment_type' => 'midtrans',
                'transaction_id' => $request->transaction_id,
                'notes' => $orderData['notes'],
                'order_date' => now(),
            ]);

            foreach ($cartItems as $item) {
                $productPrice = $item->product->harga_jual ?? $item->product->harga;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $productPrice,
                    'kuantitas' => $item->kuantitas,
                    'size' => $item->size,
                    'subtotal' => $productPrice * $item->kuantitas,
                ]);

                $item->product->decrement('stock_kuantitas', $item->kuantitas);
            }

            $cartItems->each->delete();
            session()->forget('pending_order_data');

            DB::commit();

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'redirect_url' => route('orders.show', ['orderNumber' => $order->order_number])
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function success($orderNumber)
    {
        $order = Order::with('orderItems.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}