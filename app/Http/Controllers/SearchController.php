<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    /**
     * Handle AJAX search requests
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('q', '');
        $categoryId = $request->input('category_id', '');
        
        if (empty(trim($searchTerm))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Search term is required',
                'data' => []
            ]);
        }

        try {
            // Build the query using the same scope as ProductController
            $query = Product::active()->with(['category', 'images'])
                ->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('deskripsi', 'LIKE', '%' . $searchTerm . '%');
                });

            // Apply category filter if specified
            if (!empty($categoryId) && $categoryId !== 'all') {
                $query->where('category_id', $categoryId);
            }

            // Get results ordered by popularity (total_penjualan) then name
            $products = $query->orderBy('total_penjualan', 'desc')
                            ->orderBy('name', 'asc')
                            ->get();

            // Format products for frontend using the same logic as ProductController
            $formattedProducts = $products->map(function($product) {
                // Get primary image using the same logic as ProductController
                $primaryImage = $product->images()->where('is_primary', true)->first();
                $imageUrl = $primaryImage ? 
                    asset('storage/' . $primaryImage->image_path) :
                    ($product->images->isNotEmpty() ? 
                        asset('storage/' . $product->images->first()->image_path) :
                        asset('images/no-image.png'));

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category?->name,
                    'category_id' => $product->category_id,
                    'price' => $product->harga,
                    'sale_price' => $product->harga_jual,
                    'final_price' => $product->harga_jual ?? $product->harga,
                    'formatted_price' => number_format($product->harga, 0, ',', '.'),
                    'formatted_final_price' => number_format($product->harga_jual ?? $product->harga, 0, ',', '.'),
                    'is_on_sale' => $product->harga_jual && $product->harga_jual < $product->harga,
                    'total_sales' => $product->total_penjualan ?? 0,
                    'rating' => $product->rating_rata ?? 0,
                    'total_reviews' => $product->total_reviews ?? 0,
                    'stock_status' => $product->stock_kuantitas > 0 ? 'In Stock' : 'Out of Stock',
                    'is_featured' => $product->is_featured,
                    'image' => $imageUrl,
                    'url' => route('products.show', $product->slug)
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Search completed successfully',
                'data' => [
                    'products' => $formattedProducts,
                    'total' => $formattedProducts->count(),
                    'search_term' => $searchTerm,
                    'category_id' => $categoryId
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Search failed: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get search suggestions for autocomplete
     */
    public function suggestions(Request $request)
    {
        $searchTerm = $request->input('q', '');
        
        if (strlen(trim($searchTerm)) < 2) {
            return response()->json([
                'status' => 'success',
                'data' => []
            ]);
        }

        try {
            $suggestions = Product::active()
                ->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->select('name', 'slug')
                ->distinct()
                ->limit(5)
                ->orderBy('total_penjualan', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $suggestions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get suggestions',
                'data' => []
            ]);
        }
    }

    /**
     * Display search results or redirect to product detail if exact match found
     */
    public function searchPage(Request $request)
    {
        $searchTerm = $request->input('q', '');
        $categoryId = $request->input('category_id', '');
        
        if (!empty(trim($searchTerm))) {
            // First, check for exact match by name
            $exactMatch = Product::active()
                ->where('name', '=', $searchTerm)
                ->first();
            
            // If exact match found, redirect to product detail page
            if ($exactMatch) {
                return redirect()->route('products.show', $exactMatch->slug);
            }
            
            // If no exact match, check for case-insensitive exact match
            $exactMatchCaseInsensitive = Product::active()
                ->whereRaw('LOWER(name) = LOWER(?)', [$searchTerm])
                ->first();
            
            if ($exactMatchCaseInsensitive) {
                return redirect()->route('products.show', $exactMatchCaseInsensitive->slug);
            }
            
            // If still no exact match, search for similar products
            $query = Product::active()->with(['category', 'images'])
                ->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('deskripsi', 'LIKE', '%' . $searchTerm . '%');
                });

            if (!empty($categoryId) && $categoryId !== 'all') {
                $query->where('category_id', $categoryId);
            }

            $products = $query->orderBy('total_penjualan', 'desc')->paginate(12);
            
            // If only one product found, redirect to its detail page
            if ($products->total() === 1) {
                $singleProduct = $products->first();
                return redirect()->route('products.show', $singleProduct->slug);
            }
        }

        $categories = Category::all();
        $products = $products ?? collect([]);
        
        // If multiple products or no products found, show search results page
        return view('search-results', compact('products', 'searchTerm', 'categoryId', 'categories'));
    }

    /**
     * Get popular search terms
     */
    public function popularSearches()
    {
        // This could be expanded to track actual search analytics
        $popularTerms = [
            'hoodie',
            't-shirt',
            'shoes',
            'sepatu',
            'kaos',
            'jaket'
        ];

        return response()->json([
            'status' => 'success',
            'data' => $popularTerms
        ]);
    }

    /**
     * Filter products by category (for AJAX requests)
     */
    public function filterByCategory(Request $request)
    {
        $categoryId = $request->input('category_id', '');
        $searchTerm = $request->input('search', '');

        try {
            $query = Product::active()->with(['category', 'images']);

            // Apply search filter if provided
            if (!empty(trim($searchTerm))) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('deskripsi', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            // Apply category filter
            if (!empty($categoryId) && $categoryId !== 'all') {
                $query->where('category_id', $categoryId);
            }

            $products = $query->orderBy('total_penjualan', 'desc')->get();

            // Format products for frontend using same logic as ProductController
            $formattedProducts = $products->map(function($product) {
                $primaryImage = $product->images()->where('is_primary', true)->first();
                $imageUrl = $primaryImage ? 
                    asset('storage/' . $primaryImage->image_path) :
                    ($product->images->isNotEmpty() ? 
                        asset('storage/' . $product->images->first()->image_path) :
                        asset('images/no-image.png'));

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category?->name,
                    'category_id' => $product->category_id,
                    'price' => $product->harga,
                    'sale_price' => $product->harga_jual,
                    'final_price' => $product->harga_jual ?? $product->harga,
                    'formatted_price' => number_format($product->harga, 0, ',', '.'),
                    'formatted_final_price' => number_format($product->harga_jual ?? $product->harga, 0, ',', '.'),
                    'is_on_sale' => $product->harga_jual && $product->harga_jual < $product->harga,
                    'total_sales' => $product->total_penjualan ?? 0,
                    'rating' => $product->rating_rata ?? 0,
                    'total_reviews' => $product->total_reviews ?? 0,
                    'stock_status' => $product->stock_kuantitas > 0 ? 'In Stock' : 'Out of Stock',
                    'is_featured' => $product->is_featured,
                    'image' => $imageUrl,
                    'url' => route('products.show', $product->slug)
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'products' => $formattedProducts,
                    'total' => $formattedProducts->count(),
                    'category_id' => $categoryId,
                    'search_term' => $searchTerm
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Filter failed: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}