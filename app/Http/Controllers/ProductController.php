<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\InspirationalOutfit;
use App\Models\FeaturedItem;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the allProduk page with products, best sellers, inspirational outfits, and featured items
     */
    public function index(Request $request)
    {
        // Get all active products for Our Collections section
        $products = Product::with(['category', 'images', 'primaryImage'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get best seller products (top 8 by sales)
        $bestSellerProducts = Product::with(['category', 'images', 'primaryImage'])
            ->where('total_penjualan', '>', 0)
            ->orderBy('total_penjualan', 'desc')
            ->take(4)
            ->get();

        // Get active inspirational outfits
        $inspirationalOutfits = InspirationalOutfit::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get active featured items (max 4 for grid layout)
        $featuredItems = FeaturedItem::where('is_active', true)
            ->orderBy('order')
            ->take(4)
            ->get();

        // Get all categories for filter (if needed)
        $categories = Category::all();

        return view('allProduk', compact(
            'products',
            'bestSellerProducts',
            'inspirationalOutfits',
            'featuredItems',
            'categories'
        ));
    }

    /**
     * Display a single product detail page
     */
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

        // Get reviews with proper relationships and pagination
        $reviews = Review::with(['user', 'orderItem'])
            ->where('product_id', $product->id)
            ->where('is_verified', true)
            ->latest()
            ->paginate(10);

        // Calculate review statistics accurately
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

        // Review statistics array
        $reviewStats = [
            'total_reviews' => $totalReviews,
            'average_rating' => number_format($averageRating, 1),
            'rating_distribution' => $ratingDistribution,
            'recommendation_percentage' => $recommendationPercentage
        ];

        return view('detailproduk', compact('product', 'relatedProducts', 'reviews', 'reviewStats'));
    }

    /**
     * Display featured products
     */
    public function featured()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('products.featured', compact('featuredProducts'));
    }

    /**
     * Display timeless choice products
     */
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

    /**
     * Display latest products
     */
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

    /**
     * Search products
     */
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

    /**
     * Display products with active discounts
     */
    public function discounted(Request $request)
    {
        $products = Product::with(['category', 'images'])
            ->where(function ($query) {
                $query->where('is_on_sale', true)
                    ->orWhere(function ($q) {
                        $q->where('discount_percentage', '>', 0)
                            ->where(function ($dateQuery) {
                                $dateQuery->whereNull('discount_start_date')
                                    ->orWhere('discount_start_date', '<=', now());
                            })
                            ->where(function ($dateQuery) {
                                $dateQuery->whereNull('discount_end_date')
                                    ->orWhere('discount_end_date', '>=', now());
                            });
                    });
            })
            ->orderBy('discount_percentage', 'desc')
            ->paginate(12);

        return view('products.discounted', compact('products'));
    }

    /**
     * API: Get products list (JSON response)
     */
    public function api_index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        // Filter by badge type
        if ($request->filled('badge')) {
            $query->where('badge_type', $request->badge);
        }

        // Search by name or description
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_low':
                $query->orderByRaw('
                    CASE
                        WHEN discount_percentage > 0
                        AND (discount_start_date IS NULL OR discount_start_date <= NOW())
                        AND (discount_end_date IS NULL OR discount_end_date >= NOW())
                        THEN (COALESCE(harga_jual, harga) - (COALESCE(harga_jual, harga) * discount_percentage / 100))
                        ELSE COALESCE(harga_jual, harga)
                    END ASC
                ');
                break;
            case 'price_high':
                $query->orderByRaw('
                    CASE
                        WHEN discount_percentage > 0
                        AND (discount_start_date IS NULL OR discount_start_date <= NOW())
                        AND (discount_end_date IS NULL OR discount_end_date >= NOW())
                        THEN (COALESCE(harga_jual, harga) - (COALESCE(harga_jual, harga) * discount_percentage / 100))
                        ELSE COALESCE(harga_jual, harga)
                    END DESC
                ');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('total_penjualan', 'desc');
                break;
            case 'discount':
                $query->orderBy('discount_percentage', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get products with limit or pagination
        $products = $request->has('limit')
            ? $query->limit($request->limit)->get()
            : $query->paginate(12);

        return response()->json([
            'success' => true,
            'products' => $products->map(function ($product) {
                $primaryImage = $product->images()->where('is_primary', true)->first();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category?->name,
                    'price' => $product->formatted_original_price,
                    'final_price' => $product->formatted_final_price,
                    'discount_percentage' => $product->discount_percentage,
                    'has_discount' => $product->hasActiveDiscount(),
                    'image' => $primaryImage ? asset('storage/' . $primaryImage->image_path) : null,
                    'badge' => $product->badge_type ?? null,
                    'is_on_sale' => $product->is_on_sale,
                    'stock_status' => $product->stock_kuantitas > 0 ? 'In Stock' : 'Out of Stock',
                    'rating' => $product->rating_rata,
                    'url' => route('products.show', $product->slug),
                ];
            }),
            'pagination' => $products instanceof \Illuminate\Pagination\AbstractPaginator ? [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ] : null
        ]);
    }
}
