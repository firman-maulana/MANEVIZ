<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter badge_type
        if ($request->filled('badge')) {
            $query->where('badge_type', $request->badge);
        }

        // Pencarian nama / deskripsi
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('total_penjualan', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        // Get best seller products (top 4 by sales)
        $bestSellerProducts = Product::with(['category', 'images'])
            ->where('total_penjualan', '>', 0)
            ->orderBy('total_penjualan', 'desc')
            ->limit(4)
            ->get();

        // If there are less than 4 products with sales, fill with featured or newest products
        if ($bestSellerProducts->count() < 4) {
            $remainingCount = 4 - $bestSellerProducts->count();
            $bestSellerIds = $bestSellerProducts->pluck('id')->toArray();

            $additionalProducts = Product::with(['category', 'images'])
                ->whereNotIn('id', $bestSellerIds)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit($remainingCount)
                ->get();

            // If still not enough, get the newest products (non-featured)
            if ($additionalProducts->count() < $remainingCount) {
                $stillNeeded = $remainingCount - $additionalProducts->count();
                $usedIds = array_merge($bestSellerIds, $additionalProducts->pluck('id')->toArray());

                $newestProducts = Product::with(['category', 'images'])
                    ->whereNotIn('id', $usedIds)
                    ->orderBy('created_at', 'desc')
                    ->limit($stillNeeded)
                    ->get();

                $additionalProducts = $additionalProducts->concat($newestProducts);
            }

            $bestSellerProducts = $bestSellerProducts->concat($additionalProducts);
        }

        return view('allProduk', compact('products', 'categories', 'bestSellerProducts'));
    }

    // 🔥 FIXED METHOD - Removed is_active check
    public function show($slug)
    {
        // Get product with images and category
        $product = Product::with(['images', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related products from same category
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // 🔥 Get reviews with proper relationships and pagination
        $reviews = Review::with(['user', 'orderItem'])
            ->where('product_id', $product->id)
            ->where('is_verified', true)
            ->latest()
            ->paginate(10);

        // 🔥 Calculate review statistics accurately
        $totalReviews = Review::where('product_id', $product->id)
            ->where('is_verified', true)
            ->count();

        $averageRating = Review::where('product_id', $product->id)
            ->where('is_verified', true)
            ->avg('rating') ?? 0;

        // Calculate rating distribution (1-5 stars)
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = Review::where('product_id', $product->id)
                ->where('is_verified', true)
                ->where('rating', $i)
                ->count();
        }

        // Calculate recommendation percentage
        $recommendedCount = Review::where('product_id', $product->id)
            ->where('is_verified', true)
            ->where('is_recommended', true)
            ->count();

        $recommendationPercentage = $totalReviews > 0
            ? round(($recommendedCount / $totalReviews) * 100, 1)
            : 0;

        // 🔥 Review statistics array
        $reviewStats = [
            'total_reviews' => $totalReviews,
            'average_rating' => number_format($averageRating, 1), // Format to 1 decimal
            'rating_distribution' => $ratingDistribution,
            'recommendation_percentage' => $recommendationPercentage
        ];

        return view('detailproduk', compact('product', 'relatedProducts', 'reviews', 'reviewStats'));
    }

    public function featured()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('products.featured', compact('featuredProducts'));
    }

    public function timelessChoice()
    {
        $timelessProducts = Product::with(['category', 'images'])
            ->where('badge_type', '!=', 'just-in')
            ->where('created_at', '<', now()->subMonths(3))
            ->orderBy('rating_rata', 'desc')
            ->limit(6)
            ->get();

        return view('products.timeless', compact('timelessProducts'));
    }

    public function latest()
    {
        $latestProducts = Product::with(['category', 'images'])
            ->where(function ($q) {
                $q->where('badge_type', 'just-in')
                  ->orWhere('created_at', '>=', now()->subDays(30));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('products.latest', compact('latestProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return redirect()->route('products.index');
        }

        $products = Product::with(['category', 'images'])
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('deskripsi', 'like', '%' . $query . '%');
            })
            ->orderBy('total_penjualan', 'desc')
            ->paginate(12);

        return view('products.search', compact('products', 'query'));
    }

    // API
    public function api_index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        $products = $request->has('limit')
            ? $query->limit($request->limit)->get()
            : $query->paginate(12);

        return response()->json([
            'products' => $products->map(function ($product) {
                $primaryImage = $product->images()->where('is_primary', true)->first();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category?->name,
                    'price' => $product->formatted_price ?? number_format($product->harga, 0, ',', '.'),
                    'final_price' => number_format($product->final_price ?? $product->harga_jual, 0, ',', '.'),
                    'image' => $primaryImage ? asset('storage/' . $primaryImage->image_path) : null,
                    'badge' => $product->badge_type ?? null,
                    'is_on_sale' => $product->harga_jual < $product->harga,
                    'stock_status' => $product->stock_kuantitas > 0 ? 'In Stock' : 'Out of Stock',
                    'rating' => $product->rating_rata,
                    'url' => route('products.show', $product->slug),
                ];
            }),
            'pagination' => $products instanceof \Illuminate\Pagination\AbstractPaginator ? [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ] : null
        ]);
    }
}
