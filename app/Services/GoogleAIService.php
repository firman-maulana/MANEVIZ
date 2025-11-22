<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleAIService
{
    private $apiKey;
    private $apiUrl;
    private $model;

    public function __construct()
    {
        $this->apiKey = config('services.google_ai.api_key');
        $this->model = config('services.google_ai.model', 'gemini-2.5-flash');

        // Endpoint standar Gemini generateContent v1beta
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Fungsi utama memanggil Gemini
     */
    public function generateContent($systemInstruction, $prompt)
    {
        try {
            $payload = [
                "contents" => [
                    [
                        "role" => "user",
                        "parts" => [
                            [
                                "text" =>
                                    $systemInstruction . // Rules + product data
                                    "\n\n" .
                                    "User: " . $prompt
                            ]
                        ]
                    ]
                ],
                "generationConfig" => [
                    "temperature" => 0.9,
                    "maxOutputTokens" => 8192,
                ]
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    "Content-Type" => "application/json",
                ])
                ->post($this->apiUrl . "?key={$this->apiKey}", $payload);

            if (!$response->successful()) {
                Log::error("Gemini API Error", [
                    "status" => $response->status(),
                    "body" => $response->body(),
                ]);

                return "Error API: " . $response->body();
            }

            $data = $response->json();

            if (empty($data['candidates'][0]['content']['parts'])) {
                return "Tidak ada respon dari AI.";
            }

            foreach ($data['candidates'][0]['content']['parts'] as $part) {
                if (isset($part['text'])) {
                    return $part['text'];
                }
            }

            return "AI tidak mengembalikan teks yang bisa dibaca.";
        } catch (\Exception $e) {
            Log::error("Gemini Request Failed", ["error" => $e->getMessage()]);
            return "Terjadi error: " . $e->getMessage();
        }
    }



    /**
     * Membangun system instruction lengkap
     */
    public function buildSystemInstruction(array $context): string
    {
        $instruction = "Kamu adalah customer service virtual bernama 'MANEVIZ Assistant' untuk MANEVIZ, sebuah toko online fashion premium.\n\n";

        $instruction .= "INFORMASI PENTING:\n";
        $instruction .= "- Nama toko: MANEVIZ\n";
        $instruction .= "- Produk utama: Hoodie, T-Shirt, Sepatu\n";
        $instruction .= "- Bahasa: Gunakan bahasa Indonesia yang ramah dan casual\n";
        $instruction .= "- Tone: Friendly, helpful, dan knowledgeable\n\n";

        // =======================
        // PRODUK dari database
        // =======================
        if (!empty($context['products'])) {
            $instruction .= "PRODUK TERKAIT DARI DATABASE:\n\n";

            foreach ($context['products'] as $i => $product) {
                $instruction .= "Produk #" . ($i + 1) . ":\n";
                $instruction .= "├─ Nama: {$product['name']}\n";
                $instruction .= "├─ Kategori: {$product['category']}\n";
                $instruction .= "├─ Harga: IDR " . number_format($product['price'], 0, ',', '.') . "\n";

                if (!empty($product['discount'])) {
                    $saving = $product['original_price'] - $product['price'];
                    $instruction .= "├─ DISKON: {$product['discount']}%\n";
                    $instruction .= "│  Hemat: IDR " . number_format($saving, 0, ',', '.') . "\n";
                }

                $instruction .= "├─ Deskripsi: {$product['description']}\n";
                $instruction .= "├─ Stok: " . ($product['stock'] > 0 ? "{$product['stock']} tersedia ✓" : "Habis ✗") . "\n";
                $instruction .= "└─ Link: {$product['url']}\n\n";
            }
        } else {
            $instruction .= "Tidak ada produk relevan. Kamu boleh rekomendasikan berdasarkan kategori.\n\n";
        }


        // =======================
        // RULES (biarkan panjang seperti aslinya)
        // =======================
        $instruction .= "TUGAS KAMU:\n";
        $instruction .= "1. Rekomendasikan produk yang cocok\n";
        $instruction .= "2. Jelaskan kenapa produk tersebut cocok\n";
        $instruction .= "3. Beri detail harga, promo, dan link\n";
        $instruction .= "4. Jawab dengan nada friendly + conversational\n\n";

        $instruction .= "ATURAN:\n";
        $instruction .= "❌ Jangan membuat informasi palsu\n";
        $instruction .= "❌ Jangan memberikan harga yang tidak ada di database\n";
        $instruction .= "❌ Jangan terlalu formal\n\n";

        $instruction .= "Selalu berikan jawaban singkat (3-6 kalimat), jelas, informatif, dan berakhir dengan pertanyaan follow-up.\n\n";

        return $instruction;
    }
}
