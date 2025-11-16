<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WaybillTrackingService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->baseUrl = 'https://rajaongkir.komerce.id/api/v1';
    }

    /**
     * Track waybill/resi
     *
     * @param string $waybill - Nomor resi
     * @param string $courier - Kode kurir (jne, tiki, pos, jnt, sicepat, anteraja)
     * @return array
     */
    public function trackWaybill(string $waybill, string $courier): array
    {
        try {
            Log::info('Tracking waybill', [
                'waybill' => $waybill,
                'courier' => $courier
            ]);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/track/domestic", [
                'waybill' => $waybill,
                'courier' => strtolower($courier)
            ]);

            Log::info('Tracking response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => 'Failed to track waybill',
                    'error' => $response->body()
                ];
            }

            $data = $response->json();

            // Check if tracking data exists
            if (!isset($data['data']) || empty($data['data'])) {
                return [
                    'success' => false,
                    'message' => 'No tracking data found for this waybill',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'data' => $this->formatTrackingData($data['data'])
            ];

        } catch (\Exception $e) {
            Log::error('Waybill tracking error', [
                'waybill' => $waybill,
                'courier' => $courier,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error tracking waybill: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Format tracking data to standardized format
     */
    protected function formatTrackingData(array $data): array
    {
        $tracking = $data[0] ?? $data;

        return [
            'waybill' => $tracking['waybill'] ?? $tracking['waybill_number'] ?? null,
            'courier' => $tracking['courier'] ?? $tracking['courier_code'] ?? null,
            'service' => $tracking['service'] ?? $tracking['service_code'] ?? null,
            'status' => $tracking['status'] ?? null,
            'sender' => [
                'name' => $tracking['sender']['name'] ?? $tracking['shipper_name'] ?? null,
                'address' => $tracking['sender']['address'] ?? $tracking['origin'] ?? null,
            ],
            'receiver' => [
                'name' => $tracking['receiver']['name'] ?? $tracking['receiver_name'] ?? null,
                'address' => $tracking['receiver']['address'] ?? $tracking['destination'] ?? null,
            ],
            'history' => $this->formatHistory($tracking['manifest'] ?? $tracking['history'] ?? []),
            'delivered_date' => $tracking['delivered_date'] ?? null,
            'pod_receiver' => $tracking['pod_receiver'] ?? null,
            'pod_date' => $tracking['pod_date'] ?? null,
        ];
    }

    /**
     * Format tracking history/manifest
     */
    protected function formatHistory(array $manifest): array
    {
        $formatted = [];

        foreach ($manifest as $item) {
            $formatted[] = [
                'date' => $item['manifest_date'] ?? $item['date'] ?? null,
                'time' => $item['manifest_time'] ?? $item['time'] ?? null,
                'description' => $item['manifest_description'] ?? $item['description'] ?? null,
                'location' => $item['city_name'] ?? $item['location'] ?? null,
            ];
        }

        return $formatted;
    }

    /**
     * Get latest status from tracking history
     */
    public function getLatestStatus(array $trackingData): ?array
    {
        if (empty($trackingData['history'])) {
            return null;
        }

        return $trackingData['history'][0] ?? null;
    }

    /**
     * Check if package is delivered based on tracking data
     */
    public function isDelivered(array $trackingData): bool
    {
        $status = strtolower($trackingData['status'] ?? '');

        $deliveredKeywords = ['delivered', 'terkirim', 'diterima', 'selesai'];

        foreach ($deliveredKeywords as $keyword) {
            if (str_contains($status, $keyword)) {
                return true;
            }
        }

        // Check from latest history
        if (!empty($trackingData['history'])) {
            $latestDesc = strtolower($trackingData['history'][0]['description'] ?? '');
            foreach ($deliveredKeywords as $keyword) {
                if (str_contains($latestDesc, $keyword)) {
                    return true;
                }
            }
        }

        return false;
    }
}
