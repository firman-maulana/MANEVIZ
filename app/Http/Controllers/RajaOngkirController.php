<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirController extends Controller
{
    private $apiKey;
    private $baseUrl;
    private $originCityId = 254; // Malang

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        
        // FIXED: Gunakan endpoint yang benar untuk starter account
        $this->baseUrl = 'https://api.rajaongkir.com/starter';
    }

    /**
     * Get all provinces
     */
    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/province");

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['rajaongkir']['results'])) {
                    return response()->json([
                        'success' => true,
                        'data' => collect($data['rajaongkir']['results'])->map(function($province) {
                            return [
                                'id' => $province['province_id'],
                                'province_id' => $province['province_id'],
                                'name' => $province['province'],
                                'province' => $province['province']
                            ];
                        })
                    ]);
                }
            }

            Log::error('RajaOngkir Province Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch provinces'
            ], 500);

        } catch (\Exception $e) {
            Log::error('RajaOngkir Province Exception', [
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
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
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/city", [
                'province' => $provinceId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['rajaongkir']['results'])) {
                    return response()->json([
                        'success' => true,
                        'data' => collect($data['rajaongkir']['results'])->map(function($city) {
                            return [
                                'id' => $city['city_id'],
                                'city_id' => $city['city_id'],
                                'name' => $city['type'] . ' ' . $city['city_name'],
                                'city_name' => $city['type'] . ' ' . $city['city_name'],
                                'type' => $city['type']
                            ];
                        })
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities'
            ], 500);

        } catch (\Exception $e) {
            Log::error('RajaOngkir City Exception', [
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get districts - untuk starter hanya return city sebagai district
     */
    public function getDistricts($cityId)
    {
        try {
            // FIXED: Starter account tidak support subdistrict
            // Return city sebagai district
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/city", [
                'id' => $cityId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['rajaongkir']['results'])) {
                    $city = $data['rajaongkir']['results'];
                    
                    return response()->json([
                        'success' => true,
                        'data' => [[
                            'id' => $city['city_id'],
                            'subdistrict_id' => $city['city_id'],
                            'name' => $city['city_name'],
                            'subdistrict_name' => $city['city_name']
                        ]]
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch district'
            ], 500);

        } catch (\Exception $e) {
            Log::error('RajaOngkir District Exception', [
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate shipping cost
     */
    public function calculateShippingCost(Request $request)
    {
        try {
            $validated = $request->validate([
                'destination_district_id' => 'required|integer',
                'weight' => 'required|integer|min:1',
                'courier' => 'required|string|in:jne,pos,tiki'
            ]);

            $destinationCityId = $validated['destination_district_id'];
            $weight = $validated['weight'];
            $courier = strtolower($validated['courier']);

            Log::info('Calculate Shipping Request', [
                'origin' => $this->originCityId,
                'destination' => $destinationCityId,
                'weight' => $weight,
                'courier' => $courier
            ]);

            // FIXED: Gunakan asForm() untuk POST request
            $response = Http::asForm()
                ->withHeaders([
                    'key' => $this->apiKey,
                ])
                ->post("{$this->baseUrl}/cost", [
                    'origin' => $this->originCityId,
                    'destination' => $destinationCityId,
                    'weight' => $weight,
                    'courier' => $courier,
                ]);

            Log::info('RajaOngkir Cost Response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Check API status
                if (isset($data['rajaongkir']['status']['code']) && $data['rajaongkir']['status']['code'] != 200) {
                    return response()->json([
                        'success' => false,
                        'message' => 'API Error: ' . ($data['rajaongkir']['status']['description'] ?? 'Unknown error')
                    ], 400);
                }
                
                if (isset($data['rajaongkir']['results']) && !empty($data['rajaongkir']['results'])) {
                    return response()->json([
                        'success' => true,
                        'data' => $data['rajaongkir']['results']
                    ]);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada layanan pengiriman tersedia untuk tujuan ini'
                ], 404);
            }

            Log::error('RajaOngkir Cost HTTP Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung ongkos kirim. Status: ' . $response->status()
            ], $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Calculate Cost Exception', [
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
     * Get available couriers untuk starter account
     */
    public function getAvailableCouriers()
    {
        // FIXED: Starter account hanya support 3 kurir
        return response()->json([
            'success' => true,
            'data' => [
                ['code' => 'jne', 'name' => 'JNE'],
                ['code' => 'pos', 'name' => 'POS Indonesia'],
                ['code' => 'tiki', 'name' => 'TIKI'],
            ]
        ]);
    }

    /**
     * Get origin info
     */
    public function getOriginInfo()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'city_id' => $this->originCityId,
                'city_name' => 'Malang',
                'province_name' => 'Jawa Timur',
                'note' => 'Using Starter account - city level only'
            ]
        ]);
    }
}