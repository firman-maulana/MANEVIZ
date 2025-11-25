<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class OrderHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display order history (delivered and cancelled orders)
    public function index(Request $request)
    {
        $query = Order::with(['orderItems.product.images', 'orderItems.review'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['delivered', 'cancelled'])
            ->orderBy('updated_at', 'desc');

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where(function($q) use ($request) {
                $q->where(function($subQ) use ($request) {
                    $subQ->where('status', 'delivered')
                         ->whereDate('delivered_date', '>=', $request->date_from);
                })->orWhere(function($subQ) use ($request) {
                    $subQ->where('status', 'cancelled')
                         ->whereDate('updated_at', '>=', $request->date_from);
                });
            });
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->where(function($q) use ($request) {
                $q->where(function($subQ) use ($request) {
                    $subQ->where('status', 'delivered')
                         ->whereDate('delivered_date', '<=', $request->date_to);
                })->orWhere(function($subQ) use ($request) {
                    $subQ->where('status', 'cancelled')
                         ->whereDate('updated_at', '<=', $request->date_to);
                });
            });
        }

        // Filter by status
        if ($request->has('order_status') && $request->order_status) {
            $query->where('status', $request->order_status);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('status', 'delivered')
                  ->whereHas('orderItems.review', function($q) use ($request) {
                      $q->where('rating', $request->rating);
                  });
        }

        // Filter by reviewed/unreviewed
        if ($request->has('review_status') && $request->review_status) {
            $query->where('status', 'delivered');
            if ($request->review_status === 'reviewed') {
                $query->whereHas('orderItems.review');
            } elseif ($request->review_status === 'unreviewed') {
                $query->whereDoesntHave('orderItems.review');
            }
        }

        $orders = $query->paginate(10);

        return view('order-history.index', compact('orders'));
    }

    // Show order detail in history
    public function show($orderNumber)
    {
        $order = Order::with(['orderItems.product.images', 'orderItems.review'])
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['delivered', 'cancelled'])
            ->firstOrFail();

        return view('order-history.show', compact('order'));
    }

    // Show review form (only for delivered orders)
    public function showReviewForm($orderItemId)
    {
        $orderItem = \App\Models\OrderItem::with(['order', 'product.images'])
            ->whereHas('order', function($query) {
                $query->where('user_id', Auth::id())
                      ->where('status', 'delivered');
            })
            ->where('id', $orderItemId)
            ->firstOrFail();

        // Check if already reviewed
        $existingReview = Review::where('order_item_id', $orderItemId)->first();
        if ($existingReview) {
            return redirect()->route('order-history.index')
                           ->with('error', 'You have already reviewed this product');
        }

        return view('order-history.review-form', compact('orderItem'));
    }

    // Submit review (only for delivered orders)
    public function submitReview(Request $request, $orderItemId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'is_recommended' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $orderItem = \App\Models\OrderItem::with('order')
            ->whereHas('order', function($query) {
                $query->where('user_id', Auth::id())
                      ->where('status', 'delivered');
            })
            ->where('id', $orderItemId)
            ->firstOrFail();

        // PERBAIKAN: Hapus pengecekan review yang sudah ada sebelum menyimpan
        // Karena ini sudah dicek di showReviewForm, tidak perlu dicek lagi di sini
        // Ini mencegah race condition dan duplikasi pengecekan

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review-images', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create review
        try {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $orderItem->product_id,
                'order_id' => $orderItem->order_id,
                'order_item_id' => $orderItemId,
                'rating' => $request->rating,
                'review' => $request->review,
                'images' => $imagePaths ?: null,
                'is_recommended' => $request->boolean('is_recommended', true),
                'is_verified' => true
            ]);

            return redirect()->route('order-history.index')
                           ->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            // Jika terjadi error (misalnya duplicate entry), redirect dengan pesan error
            // Hapus gambar yang sudah diupload jika ada error
            if (!empty($imagePaths)) {
                foreach ($imagePaths as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
            
            return redirect()->route('order-history.index')
                           ->with('error', 'Failed to submit review. Please try again.');
        }
    }

    // Edit review
    public function editReview($reviewId)
    {
        $review = Review::with(['orderItem.product.images', 'orderItem.order'])
            ->where('user_id', Auth::id())
            ->where('id', $reviewId)
            ->firstOrFail();

        return view('order-history.edit-review', compact('review'));
    }

    // Update review
    public function updateReview(Request $request, $reviewId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'is_recommended' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'remove_images' => 'array',
            'remove_images.*' => 'string'
        ]);

        $review = Review::where('user_id', Auth::id())
                       ->where('id', $reviewId)
                       ->firstOrFail();

        // Handle image removal
        $currentImages = $review->images ?: [];
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageToRemove) {
                if (in_array($imageToRemove, $currentImages)) {
                    // Remove from storage
                    Storage::disk('public')->delete($imageToRemove);
                    // Remove from array
                    $currentImages = array_values(array_diff($currentImages, [$imageToRemove]));
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review-images', 'public');
                $currentImages[] = $path;
            }
        }

        // Update review
        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
            'images' => empty($currentImages) ? null : $currentImages,
            'is_recommended' => $request->boolean('is_recommended', true)
        ]);

        return redirect()->route('order-history.index')
                       ->with('success', 'Review updated successfully!');
    }

    // Delete review
    public function deleteReview($reviewId)
    {
        $review = Review::where('user_id', Auth::id())
                       ->where('id', $reviewId)
                       ->firstOrFail();

        // Delete images from storage
        if ($review->images) {
            foreach ($review->images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $review->delete();

        return redirect()->route('order-history.index')
                       ->with('success', 'Review deleted successfully!');
    }
}