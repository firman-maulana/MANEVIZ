<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\WaybillTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    protected $trackingService;

    public function __construct(WaybillTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Get tracking information for an order
     */
    public function getTracking($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->waybill_number) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking number not available yet'
            ], 404);
        }

        // ===== UNTUK DEMO: GENERATE DUMMY TRACKING =====
        // Jika tracking history kosong, generate dummy
        if (!$order->tracking_history) {
            $dummyTracking = $this->generateDummyTracking($order);

            $order->update([
                'tracking_history' => $dummyTracking,
                'last_tracking_update' => now(),
            ]);
        } else {
            // Jika sudah ada, update timestamp saja
            $order->update([
                'last_tracking_update' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'waybill' => $order->waybill_number,
                'courier' => $order->courier_label,
                'service' => $order->courier_service,
                'status' => $order->status,
                'tracking' => [
                    'history' => $order->tracking_history
                ],
                'last_update' => $order->last_tracking_update->format('d M Y H:i'),
            ]
        ]);
    }

    // Tambahkan method helper ini
    private function generateDummyTracking($order): array
    {
        $baseDate = $order->shipped_date ?? $order->order_date ?? now();

        return [
            [
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i'),
                'description' => 'Paket telah diterima oleh ' . strtoupper($order->shipping_name ?? 'CUSTOMER'),
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ],
            [
                'date' => now()->subHours(2)->format('Y-m-d'),
                'time' => now()->subHours(2)->format('H:i'),
                'description' => 'Paket sedang dalam proses pengiriman',
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ],
            [
                'date' => now()->subHours(6)->format('Y-m-d'),
                'time' => now()->subHours(6)->format('H:i'),
                'description' => 'Paket telah berangkat dari sorting center',
                'location' => 'SURABAYA'
            ],
            [
                'date' => $baseDate->format('Y-m-d'),
                'time' => '20:00',
                'description' => 'Paket telah tiba di sorting center',
                'location' => 'SURABAYA'
            ],
            [
                'date' => $baseDate->format('Y-m-d'),
                'time' => $baseDate->format('H:i'),
                'description' => 'Paket telah diterima oleh kurir',
                'location' => 'MALANG'
            ]
        ];
    }

    /**
     * Get cached tracking from database
     */
    public function getCachedTracking($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->waybill_number) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking number not available yet'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'waybill' => $order->waybill_number,
                'courier' => $order->courier_label,
                'service' => $order->courier_service,
                'status' => $order->status,
                'tracking_history' => $order->tracking_history,
                'last_update' => $order->last_tracking_update ? $order->last_tracking_update->format('d M Y H:i') : null,
            ]
        ]);
    }
}
