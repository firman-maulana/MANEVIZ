<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\GoogleAIService;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
    protected $aiService;

    public function __construct(GoogleAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $userMessage = $request->message;

            // Cari produk terkait dari database
            $productContext = $this->getProductContext($userMessage);

            // Kirim ke Gemini (AI)
            $response = $this->aiService->generateContent(
                systemInstruction: $this->aiService->buildSystemInstruction([
                    'products' => $productContext
                ]),
                prompt: $userMessage
            );

            // Jika AI kadang return array → ubah jadi string
            if (is_array($response)) {
                $response = json_encode($response, JSON_PRETTY_PRINT);
            }

            return response()->json([
                'success' => true,
                'message' => $response,
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan. Silakan coba lagi.',
            ], 500);
        }
    }

    private function getProductContext($userMessage)
    {
        $keywords = $this->extractKeywords($userMessage);

        if (empty($keywords)) {
            $products = Product::with(['category', 'primaryImage'])
                ->where('status', 'active')
                ->limit(3)
                ->get();
        } else {
            $products = Product::with(['category', 'primaryImage'])
                ->where('status', 'active')
                ->where(function($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->orWhere('name', 'LIKE', "%{$keyword}%")
                            ->orWhere('deskripsi', 'LIKE', "%{$keyword}%")
                            ->orWhere('deskripsi_singkat', 'LIKE', "%{$keyword}%");
                    }
                })
                ->limit(5)
                ->get();
        }

        return $products->map(function($product) {
            return [
                'name' => $product->name,
                'price' => $product->final_price,
                'original_price' => $product->getOriginalPrice(),
                'description' => $product->deskripsi_singkat,
                'stock' => $product->stock_kuantitas,
                'category' => $product->category->name ?? 'Uncategorized',
                'discount' => $product->hasActiveDiscount() ? $product->discount_percentage : null,
                'url' => url('/produk/' . $product->slug),
                'image' => $product->primaryImage ? asset('storage/' . $product->primaryImage->image_url) : null,
            ];
        })->toArray();
    }

    private function extractKeywords($message)
    {
        $commonWords = [
            'saya','mau','cari','ada','yang','beli','butuh','perlu',
            'ingin','minta','dong','nih','kak','min','bang','gan',
            'produk','barang','item','jual','harga','berapa','untuk',
            'apa','siapa','dimana','kapan','kenapa','bagaimana'
        ];

        $message = strtolower($message);
        $message = preg_replace('/[^\w\s]/', ' ', $message);

        $words = preg_split('/\s+/', $message);
        $keywords = array_diff($words, $commonWords);

        return array_values(array_filter($keywords, fn($w) => strlen($w) > 2));
    }

    public function getProductSuggestions(Request $request)
    {
        $query = $request->query('q', '');

        $products = Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi_singkat', 'LIKE', "%{$query}%");
            })
            ->limit(3)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 'IDR ' . number_format($product->final_price, 0, ',', '.'),
                    'image' => $product->primaryImage ? asset('storage/' . $product->primaryImage->image_url) : asset('image/default-product.png'),
                    'url' => url('/produk/' . $product->slug),
                    'discount' => $product->hasActiveDiscount() ? $product->discount_percentage : null,
                ];
            });

        return response()->json($products);
    }

    // public function testConnection()
    // {
    //     try {
    //         $isConnected = $this->aiService->testConnection();

    //         return response()->json([
    //             'success' => $isConnected,
    //             'message' => $isConnected ? 'Connected to Gemini API' : 'Failed to connect to Gemini API'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
