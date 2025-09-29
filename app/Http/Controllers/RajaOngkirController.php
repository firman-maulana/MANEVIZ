<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirController extends Controller
{
    private $apiKey;
    private $baseUrl = 'https://rajaongkir.komerce.id/api/v1';
    
    // Kecamatan Pakisaji, Kabupaten Malang, Jawa Timur
    private $originDistrictId = 3888;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
    }

    /**
     * Get all provinces
     */
    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/destination/province");

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'data' => $data['data'] ?? []
                ]);
            }

            Log::error('RajaOngkir Province Error: ' . $response->body());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch provinces'
            ], 500);

        } catch (\Exception $e) {
            Log::error('RajaOngkir Province Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching provinces'
            ], 500);
        }
    }

    /**
     * Get cities by province ID
     */
    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/destination/city/{$provinceId}");

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'data' => $data['data'] ?? []
                ]);
            }

            Log::error('RajaOngkir City Error: ' . $response->body());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities'
            ], 500);

        } catch (\Exception $e) {
            Log::error('RajaOngkir City Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cities'
            ], 500);
        }
    }

    /**
     * Get districts by city ID
     */
    public function getDistricts($cityId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/destination/district/{$cityId}");

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'data' => $data['data'] ?? []
                ]);
            }

            Log::error('RajaOngkir District Error: ' . $response->body());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch districts'
            ], 500);

        } catch (\Exception $e) {
            Log::error('RajaOngkir District Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching districts'
            ], 500);
        }
    }

    /**
     * Calculate shipping cost
     */
    public function calculateShippingCost(Request $request)
    {
        try {
            $request->validate([
                'destination_district_id' => 'required|integer',
                'weight' => 'required|integer|min:1',
                'courier' => 'required|string'
            ]);

            Log::info('Calculating shipping cost', [
                'origin' => $this->originDistrictId,
                'destination' => $request->destination_district_id,
                'weight' => $request->weight,
                'courier' => $request->courier
            ]);

            $response = Http::asForm()->withHeaders([
                'Accept' => 'application/json',
                'key' => $this->apiKey,
            ])->post("{$this->baseUrl}/calculate/domestic-cost", [
                'origin' => $this->originDistrictId, // Kecamatan Pakisaji
                'destination' => $request->destination_district_id,
                'weight' => $request->weight,
                'courier' => $request->courier,
            ]);

            Log::info('RajaOngkir Response Status: ' . $response->status());
            Log::info('RajaOngkir Response: ' . $response->body());

            if ($response->successful()) {
                $data = $response->json();
                
                // Check if there's actual cost data
                if (!isset($data['data']) || empty($data['data'])) {
                    Log::warning('No shipping data returned from RajaOngkir', ['response' => $data]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada layanan pengiriman yang tersedia untuk tujuan ini'
                    ], 404);
                }
                
                return response()->json([
                    'success' => true,
                    'data' => $data['data']
                ]);
            }

            // Log error response
            Log::error('RajaOngkir Calculate Cost Error Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung ongkos kirim. Silakan coba lagi atau pilih kurir lain.'
            ], 500);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('RajaOngkir Calculate Cost Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available couriers
     */
    public function getAvailableCouriers()
    {
        return response()->json([
            'success' => true,
            'data' => [
                ['code' => 'jne', 'name' => 'JNE'],
                ['code' => 'tiki', 'name' => 'TIKI'],
                ['code' => 'pos', 'name' => 'POS Indonesia'],
                ['code' => 'jnt', 'name' => 'J&T Express'],
                ['code' => 'sicepat', 'name' => 'SiCepat'],
                ['code' => 'anteraja', 'name' => 'AnterAja'],
            ]
        ]);
    }

    /**
     * Get origin district info (for debugging)
     */
    public function getOriginInfo()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'district_id' => $this->originDistrictId,
                'district_name' => 'Pakisaji',
                'city_name' => 'Kabupaten Malang',
                'province_name' => 'Jawa Timur'
            ]
        ]);
    }
}