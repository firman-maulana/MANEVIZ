<?php
// File: app/Http/Controllers/DiscountController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DiscountController extends Controller
{
    /**
     * Check if a product's discount is still active
     */
    public function checkDiscountStatus(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $isActive = $product->hasActiveDiscount();
        
        return response()->json([
            'success' => true,
            'product_id' => $product->id,
            'is_active' => $isActive,
            'discount_percentage' => $isActive ? $product->discount_percentage : 0,
            'original_price' => $product->getOriginalPrice(),
            'final_price' => $product->final_price,
            'discount_amount' => $isActive ? $product->getDiscountAmount() : 0,
            'discount_label' => $isActive ? $product->getDiscountLabel() : null,
            'discount_end_date' => $product->discount_end_date 
                ? $product->discount_end_date->toIso8601String() 
                : null,
            'time_remaining' => $this->getTimeRemaining($product),
        ]);
    }

    /**
     * Batch check multiple products' discount status
     */
    public function batchCheckDiscountStatus(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->product_ids)->get();
        $results = [];

        foreach ($products as $product) {
            $isActive = $product->hasActiveDiscount();
            
            $results[] = [
                'product_id' => $product->id,
                'is_active' => $isActive,
                'discount_percentage' => $isActive ? $product->discount_percentage : 0,
                'original_price' => $product->getOriginalPrice(),
                'final_price' => $product->final_price,
                'discount_amount' => $isActive ? $product->getDiscountAmount() : 0,
                'discount_label' => $isActive ? $product->getDiscountLabel() : null,
                'time_remaining' => $this->getTimeRemaining($product),
            ];
        }

        return response()->json([
            'success' => true,
            'products' => $results,
        ]);
    }

    /**
     * Get active discounts (for homepage/listing pages)
     */
    public function getActiveDiscounts(Request $request)
    {
        // Cache for 5 minutes
        $cacheKey = 'active_discounts_' . md5($request->fullUrl());
        
        $products = Cache::remember($cacheKey, 300, function () use ($request) {
            $query = Product::with(['category', 'images'])
                ->withActiveDiscount()
                ->orderBy('discount_percentage', 'desc');

            if ($request->has('limit')) {
                return $query->limit($request->limit)->get();
            }

            return $query->paginate($request->get('per_page', 12));
        });

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'discount_percentage' => $product->discount_percentage,
                'discount_label' => $product->getDiscountLabel(),
                'original_price' => $product->getOriginalPrice(),
                'final_price' => $product->final_price,
                'discount_amount' => $product->getDiscountAmount(),
                'discount_end_date' => $product->discount_end_date 
                    ? $product->discount_end_date->toIso8601String() 
                    : null,
                'time_remaining' => $this->getTimeRemaining($product),
                'image' => $product->primaryImage 
                    ? asset('storage/' . $product->primaryImage->image_path) 
                    : null,
                'url' => route('products.show', $product->slug),
            ];
        });

        if ($products instanceof \Illuminate\Pagination\AbstractPaginator) {
            return response()->json([
                'success' => true,
                'products' => $results,
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'products' => $results,
        ]);
    }

    /**
     * Calculate time remaining for discount
     */
    private function getTimeRemaining(Product $product)
    {
        if (!$product->discount_end_date) {
            return null;
        }

        $now = now();
        $endDate = $product->discount_end_date;

        if ($now >= $endDate) {
            return [
                'expired' => true,
                'days' => 0,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
            ];
        }

        $diff = $now->diff($endDate);

        return [
            'expired' => false,
            'days' => $diff->days,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'total_seconds' => $endDate->timestamp - $now->timestamp,
        ];
    }
}