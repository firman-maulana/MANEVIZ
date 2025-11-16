<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;

class OrderTrackingSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting to generate dummy tracking data...');

        // Ambil semua order
        $orders = Order::all();

        if ($orders->isEmpty()) {
            $this->command->warn('⚠️  No orders found in database!');
            $this->command->info('💡 Please create orders first before running this seeder.');
            return;
        }

        $updated = 0;
        $skipped = 0;

        foreach ($orders as $order) {
            // Skip kalau udah ada tracking
            if ($order->tracking_history && $order->waybill_number) {
                $this->command->warn("⏭️  Skipped {$order->order_number} - Already has tracking");
                $skipped++;
                continue;
            }

            // Generate dummy waybill number
            $waybillNumber = $this->generateDummyWaybill($order->courier_code ?? 'jne');

            // Generate dummy tracking history
            $trackingHistory = $this->generateDummyTracking($order);

            // Update order
            $order->update([
                'waybill_number' => $waybillNumber,
                'tracking_history' => $trackingHistory,
                'last_tracking_update' => now(),
            ]);

            $this->command->info("✅ Updated {$order->order_number} - Waybill: {$waybillNumber}");
            $updated++;
        }

        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info("✅ Seeder completed successfully!");
        $this->command->info("📊 Updated: {$updated} orders");
        $this->command->info("⏭️  Skipped: {$skipped} orders (already have tracking)");
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }

    /**
     * Generate dummy waybill number based on courier
     */
    private function generateDummyWaybill($courier): string
    {
        $courier = strtolower($courier ?? 'jne');

        switch ($courier) {
            case 'jne':
                return 'JP' . rand(1000000000, 9999999999);

            case 'tiki':
                return str_pad(rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT);

            case 'pos':
                return 'AA' . rand(100000000, 999999999) . 'ID';

            case 'jnt':
            case 'j&t':
                return 'JD' . rand(1000000000, 9999999999);

            case 'sicepat':
                return str_pad(rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT);

            case 'anteraja':
                return str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);

            default:
                return 'TRK' . rand(100000000000, 999999999999);
        }
    }

    /**
     * Generate realistic dummy tracking history
     */
    private function generateDummyTracking($order): array
    {
        $baseDate = $order->shipped_date ?? $order->order_date ?? now();
        $status = $order->status;

        $tracking = [];

        // Kalau order sudah delivered, kasih tracking lengkap
        if ($status === 'delivered') {
            // Status 6: Delivered (paling baru)
            $tracking[] = [
                'date' => $order->delivered_date ? $order->delivered_date->format('Y-m-d') : now()->format('Y-m-d'),
                'time' => $order->delivered_date ? $order->delivered_date->format('H:i') : now()->format('H:i'),
                'description' => 'Paket telah diterima oleh ' . strtoupper($order->shipping_name ?? 'CUSTOMER'),
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ];

            // Status 5: On Delivery
            $tracking[] = [
                'date' => now()->subHours(2)->format('Y-m-d'),
                'time' => now()->subHours(2)->format('H:i'),
                'description' => 'Paket sedang dalam proses pengiriman ke alamat tujuan',
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ];
        } elseif ($status === 'shipped') {
            // Status 5: On Delivery (untuk yang masih shipped)
            $tracking[] = [
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i'),
                'description' => 'Paket sedang dalam proses pengiriman ke alamat tujuan',
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ];
        }

        // Status 4: Departed from Sorting Center
        $tracking[] = [
            'date' => $baseDate->copy()->addHours(12)->format('Y-m-d'),
            'time' => '08:00',
            'description' => 'Paket telah berangkat dari sorting center menuju kota tujuan',
            'location' => 'SURABAYA'
        ];

        // Status 3: Arrived at Sorting Center
        $tracking[] = [
            'date' => $baseDate->copy()->addHours(8)->format('Y-m-d'),
            'time' => '20:00',
            'description' => 'Paket telah tiba di sorting center dan sedang dalam proses sortir',
            'location' => 'SURABAYA'
        ];

        // Status 2: In Transit to Sorting Center
        $tracking[] = [
            'date' => $baseDate->copy()->addHours(3)->format('Y-m-d'),
            'time' => $baseDate->copy()->addHours(3)->format('H:i'),
            'description' => 'Paket dalam perjalanan menuju sorting center',
            'location' => 'MALANG'
        ];

        // Status 1: Package Picked Up (paling lama)
        $tracking[] = [
            'date' => $baseDate->format('Y-m-d'),
            'time' => $baseDate->format('H:i'),
            'description' => 'Paket telah diterima oleh kurir dan siap dikirim',
            'location' => 'MALANG'
        ];

        return $tracking;
    }
}
