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
use Illuminate\Support\Facades\Log;

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

        // 🔥 HANDLE ITEMS PARAMETER (for Buy Now or specific cart items)
        if ($request->has('items')) {
            $itemIds = explode(',', $request->get('items'));
            $selectedItems = Cart::with('product.images')
                ->whereIn('id', $itemIds)
                ->where('user_id', Auth::id())
                ->get();

            // 🔥 LOG: untuk debugging
            \Log::info('Checkout with specific items:', [
                'item_ids' => $itemIds,
                'found_items' => $selectedItems->count()
            ]);
        } else {
            // If no items specified, get ALL cart items
            $selectedItems = Cart::with('product.images')
                ->where('user_id', Auth::id())
                ->get();

            \Log::info('Checkout with all cart items:', [
                'total_items' => $selectedItems->count()
            ]);
        }

        // 🔥 VALIDATION: Redirect if no items selected
        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tidak ada item yang dipilih untuk checkout');
        }

        // Get user addresses
        $userAddresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $defaultAddress = $userAddresses->where('is_default', true)->first();

        // 🔥 CALCULATE WITH DISCOUNT
        $subtotalBeforeDiscount = 0;
        $subtotal = 0;
        $totalDiscount = 0;

        foreach ($selectedItems as $item) {
            $product = $item->product;
            $originalPrice = $product->getOriginalPrice();
            $finalPrice = $product->final_price;
            $hasDiscount = $product->hasActiveDiscount() || $product->is_on_sale;

            $subtotalBeforeDiscount += $originalPrice * $item->kuantitas;
            $subtotal += $finalPrice * $item->kuantitas;

            if ($hasDiscount) {
                $totalDiscount += $product->getDiscountAmount() * $item->kuantitas;
            }
        }

        // Calculate total weight in GRAMS
        $totalWeight = $selectedItems->sum(function ($item) {
            $weight = $item->product->berat ?? 1000;

            if ($weight > 0 && $weight < 100) {
                $weight = $weight * 1000;
            }

            return $weight * $item->kuantitas;
        });

        $totalWeight = round($totalWeight);
        $totalWeightKg = $totalWeight / 1000;
        $tax = $subtotal * 0.025;
        $shipping = 0;
        $total = $subtotal + $tax + $shipping;

        return view('checkout', compact(
            'selectedItems',
            'subtotal',
            'subtotalBeforeDiscount',
            'totalDiscount',
            'tax',
            'shipping',
            'total',
            'userAddresses',
            'defaultAddress',
            'totalWeight',
            'totalWeightKg'
        ));
    }

    public function createPayment(Request $request)
    {
        Log::info('Create Payment Request:', $request->all());

        // BASE VALIDATION
        $request->validate([
            'items' => 'required|string',
            'selected_address' => 'required',
            'courier_code' => 'required|string',
            'courier_service' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'same_as_shipping' => 'nullable|boolean',
        ]);

        // CONDITIONAL VALIDATION for manual address
        if ($request->selected_address === 'manual') {
            $request->validate([
                'shipping_name' => 'required|string|max:255',
                'shipping_email' => 'required|email|max:255',
                'shipping_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string',
                'shipping_city' => 'required|string|max:255',
                'shipping_province' => 'required|string|max:255',
                'shipping_postal_code' => 'required|string|max:10',
                'shipping_district_id' => 'required|integer',
            ]);
        } else {
            $request->validate([
                'shipping_district_id' => 'nullable|integer',
            ]);
        }

        // BILLING ADDRESS validation
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

            foreach ($cartItems as $item) {
                if ($item->product->stock_kuantitas < $item->kuantitas) {
                    throw new \Exception("Stok {$item->product->name} tidak mencukupi");
                }
            }

            $totalWeight = $cartItems->sum(function ($item) {
                $weight = $item->product->berat ?? 1000;
                if ($weight > 0 && $weight < 100) {
                    $weight = $weight * 1000;
                }
                return $weight * $item->kuantitas;
            });

            $totalWeight = round($totalWeight);

            $selectedAddressId = null;
            $shippingData = [];

            // PROCESS ADDRESS DATA
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
                    'phone' => $address->phone ?? Auth::user()->phone ?? '08123456789',
                    'address' => $address->address,
                    'city' => $address->city,
                    'province' => $address->province,
                    'postal_code' => $address->postal_code,
                    'district_id' => $address->district_id ?? $request->shipping_district_id ?? null,
                ];

                if (empty($shippingData['phone']) || $shippingData['phone'] === '08123456789') {
                    throw new \Exception('Nomor telepon tidak tersedia. Silakan lengkapi nomor telepon di profil Anda.');
                }
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

            // Validate shipping data completeness
            if (
                empty($shippingData['name']) || empty($shippingData['email']) ||
                empty($shippingData['phone']) || empty($shippingData['address']) ||
                empty($shippingData['city']) || empty($shippingData['province']) ||
                empty($shippingData['postal_code'])
            ) {
                throw new \Exception('Data alamat tidak lengkap. Pastikan semua field terisi.');
            }

            // 🔥 CALCULATE WITH DISCOUNT
            $subtotalBeforeDiscount = 0;
            $subtotal = 0;
            $totalDiscount = 0;

            foreach ($cartItems as $item) {
                $product = $item->product;
                $originalPrice = $product->getOriginalPrice();
                $finalPrice = $product->final_price;
                $hasDiscount = $product->hasActiveDiscount() || $product->is_on_sale;

                $subtotalBeforeDiscount += $originalPrice * $item->kuantitas;
                $subtotal += $finalPrice * $item->kuantitas;

                if ($hasDiscount) {
                    $totalDiscount += $product->getDiscountAmount() * $item->kuantitas;
                }
            }

            $tax = $subtotal * 0.025;
            $shippingCost = floatval($request->shipping_cost);
            $grandTotal = $subtotal + $tax + $shippingCost;

            // Generate real order number immediately
            $orderNumber = Order::generateOrderNumber();

            // Create order immediately in database with pending payment status
            DB::beginTransaction();

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'address_id' => $selectedAddressId,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $grandTotal,
                'total_amount' => $subtotal,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'total_weight' => $totalWeight,
                'courier_code' => strtoupper($request->courier_code),
                'courier_service' => $request->courier_service,
                'shipping_name' => $shippingData['name'],
                'shipping_email' => $shippingData['email'],
                'shipping_phone' => $shippingData['phone'],
                'shipping_address' => $shippingData['address'],
                'shipping_city' => $shippingData['city'],
                'shipping_province' => $shippingData['province'],
                'shipping_postal_code' => $shippingData['postal_code'],
                'shipping_district_id' => $shippingData['district_id'] ?? null,
                'billing_name' => !$request->same_as_shipping ? $request->billing_name : $shippingData['name'],
                'billing_email' => !$request->same_as_shipping ? $request->billing_email : $shippingData['email'],
                'billing_phone' => !$request->same_as_shipping ? $request->billing_phone : $shippingData['phone'],
                'billing_address' => !$request->same_as_shipping ? $request->billing_address : $shippingData['address'],
                'billing_city' => !$request->same_as_shipping ? $request->billing_city : $shippingData['city'],
                'billing_province' => !$request->same_as_shipping ? $request->billing_province : $shippingData['province'],
                'billing_postal_code' => !$request->same_as_shipping ? $request->billing_postal_code : $shippingData['postal_code'],
                'payment_method' => 'midtrans',
                'payment_status' => 'pending',
                'payment_type' => 'midtrans',
                'notes' => $request->notes,
                'order_date' => now(),
            ]);

            // Create order items with final discounted prices
            foreach ($cartItems as $item) {
                $finalPrice = $item->product->final_price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $finalPrice, // 🔥 USE DISCOUNTED PRICE
                    'kuantitas' => $item->kuantitas,
                    'size' => $item->size,
                    'subtotal' => $finalPrice * $item->kuantitas,
                ]);

                // Decrement stock
                $item->product->decrement('stock_kuantitas', $item->kuantitas);
            }

            DB::commit();

            // Create order data for Midtrans
            $orderData = [
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'total' => $grandTotal,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'total_weight' => $totalWeight,
                'courier_code' => strtoupper($request->courier_code),
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

            Log::info('Order Data for Snap Token:', $orderData);

            $snapToken = $this->midtransService->createSnapTokenFromData($orderData);

            if (!$snapToken) {
                throw new \Exception('Failed to create payment token');
            }

            // Update order with snap token
            $order->update(['snap_token' => $snapToken]);

            // Store cart item IDs in session to delete after successful payment
            session(['cart_items_to_delete' => $cartItems->pluck('id')->toArray()]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_number' => $orderNumber,
                'order_id' => $order->id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::error('Validation Error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment Creation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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
            $order = Order::where('order_number', $request->order_number)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                throw new \Exception('Order not found');
            }

            $transactionStatus = $this->midtransService->getTransactionStatus($request->transaction_id);
            $status = is_object($transactionStatus) ? $transactionStatus->transaction_status : $transactionStatus['transaction_status'];

            if (!in_array($status, ['capture', 'settlement'])) {
                throw new \Exception('Payment not completed');
            }

            DB::beginTransaction();

            // Update order
            $order->update([
                'status' => 'processing',
                'payment_status' => 'paid',
                'transaction_id' => $request->transaction_id,
            ]);

            // Delete cart items
            $cartItemIds = session('cart_items_to_delete', []);
            if (!empty($cartItemIds)) {
                Cart::whereIn('id', $cartItemIds)->delete();
                session()->forget('cart_items_to_delete');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'redirect_url' => route('checkout.success', ['orderNumber' => $order->order_number])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment Success Handler Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function success($orderNumber)
    {
        $order = Order::with('orderItems.product.images')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
