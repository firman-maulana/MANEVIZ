<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirController extends Controller
{
    /**
     * Menampilkan daftar provinsi dari API Raja Ongkir
     */
    public function index()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

            if ($response->successful()) {
                $responseData = $response->json();
                $provinces = $responseData['data'] ?? [];

                return response()->json([
                    'success' => true,
                    'data' => $provinces
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch provinces'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Province fetch error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil data kota berdasarkan ID provinsi
     */
    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

            if ($response->successful()) {
                $responseData = $response->json();
                $cities = $responseData['data'] ?? [];

                return response()->json([
                    'success' => true,
                    'data' => $cities
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities'
            ], 500);
        } catch (\Exception $e) {
            Log::error('City fetch error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil data kecamatan berdasarkan ID kota
     */
    public function getDistricts($cityId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

            if ($response->successful()) {
                $responseData = $response->json();
                $districts = $responseData['data'] ?? [];

                return response()->json([
                    'success' => true,
                    'data' => $districts
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch districts'
            ], 500);
        } catch (\Exception $e) {
            Log::error('District fetch error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghitung ongkos kirim berdasarkan data yang diberikan
     */
    public function checkOngkir(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'destination_district_id' => 'required|integer',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string'
        ]);

        try {
            Log::info('=== RAJAONGKIR CHECK ONGKIR REQUEST ===', [
                'origin' => 3942,
                'destination' => $validated['destination_district_id'],
                'weight' => $validated['weight'],
                'courier' => $validated['courier']
            ]);

            $response = Http::asForm()->withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin' => 3942, // ID kecamatan Diwek
                'destination' => $validated['destination_district_id'],
                'weight' => $validated['weight'],
                'courier' => $validated['courier'],
            ]);

            Log::info('=== RAJAONGKIR RAW RESPONSE ===', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('=== RAJAONGKIR PARSED RESPONSE ===', [
                    'full_response' => $responseData
                ]);

                // Extract data - handle multiple possible structures
                $data = $responseData['data'] ?? $responseData['results'] ?? [];

                // Ensure data is properly formatted
                if (!empty($data)) {
                    // If data is not already an array of courier results, wrap it
                    if (!isset($data[0])) {
                        $data = [$data];
                    }

                    Log::info('=== EXTRACTED DATA ===', [
                        'data' => $data,
                        'count' => count($data)
                    ]);

                    return response()->json([
                        'success' => true,
                        'data' => $data,
                        'raw_response' => $responseData // Include for debugging
                    ]);
                }

                Log::warning('No shipping data found in response');
                return response()->json([
                    'success' => false,
                    'message' => 'No shipping options available',
                    'raw_response' => $responseData
                ], 404);
            }

            Log::error('RajaOngkir API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate shipping cost',
                'error' => $response->body()
            ], $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Shipping calculation error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error calculating shipping: ' . $e->getMessage()
            ], 500);
        }
    }
}
