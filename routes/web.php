<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentConfirmationController; // ADDED: Payment Confirmation Controller

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================
// Halaman Umum (Public)
// ====================
// UPDATED: Changed from static view to dynamic controller
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/allProduct', [ProductController::class, 'index'])->name('products.index');
Route::view('/about', 'about')->name('about');

// UPDATED: Contact routes - changed from static view to dynamic controller with CRUD
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::view('/refundPolicy', 'refundPolicy')->name('refund.policy');
Route::view('/howToOrder', 'howToOrder')->name('how.to.order');

// UPDATED: Payment Confirmation routes - changed from static view to dynamic controller with CRUD
Route::get('/paymentConfirmation', [PaymentConfirmationController::class, 'index'])->name('payment.confirmation');
Route::post('/paymentConfirmation', [PaymentConfirmationController::class, 'store'])->name('payment.confirmation.store');

// API route for checking payment confirmation status (optional)
Route::get('/api/payment-confirmation/status', [PaymentConfirmationController::class, 'checkStatus'])->name('payment.confirmation.status');

// Detail Produk (ambil dari database lewat ProductController)
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');

// =====================
// Guest (Belum Login)
// =====================
Route::middleware('guest')->group(function () {
    // Sign Up
    Route::get('/signUp', [RegisterController::class, 'showsignUpForm'])->name('signUp');
    Route::post('/signUp', [RegisterController::class, 'signUp']);

    // Sign In
    Route::get('/signIn', [AuthController::class, 'showsignInForm'])->name('signIn');
    Route::get('/login', [AuthController::class, 'showsignInForm'])->name('login');
    Route::post('/signIn', [AuthController::class, 'signIn']);
});

// =====================
// Authenticated (Sudah Login)
// =====================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::put('/profil/update', [ProfileController::class, 'updateProfile'])->name('profil.update');
    Route::put('/profil/update-password', [ProfileController::class, 'updatePassword'])->name('profil.update-password');
    
    // Address Routes
    Route::prefix('address')->name('address.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::get('/create', [AddressController::class, 'create'])->name('create');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::get('/{address}/edit', [AddressController::class, 'edit'])->name('edit');
        Route::put('/{address}', [AddressController::class, 'update'])->name('update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
        Route::patch('/{address}/set-default', [AddressController::class, 'setDefault'])->name('set-default');
        Route::get('/ajax/list', [AddressController::class, 'getAddresses'])->name('ajax.list');
    });
    
    Route::view('/wishlist', 'wishlist')->name('wishlist');
    Route::view('/settings', 'settings')->name('settings');
    
    // Orders Routes (Current/Active Orders) - UPDATED for proper cancel functionality
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}', [OrdersController::class, 'show'])->name('orders.show');
    Route::get('/orders/{orderNumber}/status', [OrdersController::class, 'getStatus'])->name('orders.status');
    
    // UPDATED: Change cancel route to use form submission instead of AJAX
    Route::post('/orders/{order}/cancel', [OrdersController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/status', [OrdersController::class, 'updateStatus'])->name('orders.update-status');
    
    // Order History Routes (Delivered Orders with Reviews)
    Route::prefix('order-history')->name('order-history.')->group(function () {
        Route::get('/', [OrderHistoryController::class, 'index'])->name('index');
        Route::get('/orders/{orderNumber}', [OrderHistoryController::class, 'show'])->name('show');
        
        // Review Routes (only for delivered orders)
        Route::get('/review/{orderItem}', [OrderHistoryController::class, 'showReviewForm'])->name('review-form');
        Route::post('/review/{orderItem}', [OrderHistoryController::class, 'submitReview'])->name('submit-review');
        Route::get('/review/{review}/edit', [OrderHistoryController::class, 'editReview'])->name('edit-review');
        Route::put('/review/{review}', [OrderHistoryController::class, 'updateReview'])->name('update-review');
        Route::delete('/review/{review}', [OrderHistoryController::class, 'deleteReview'])->name('delete-review');
    });
    
    // Legacy orders route for backward compatibility
    Route::view('/orders_old', 'orders')->name('orders.old');
    
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/create-payment', [CheckoutController::class, 'createPayment'])->name('checkout.create-payment');
    Route::post('/checkout/handle-payment', [CheckoutController::class, 'handlePaymentSuccess'])->name('checkout.handle-payment');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// =====================
// Login/Register dengan Google
// =====================
Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/auth/google', [RegisterController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [RegisterController::class, 'handleGoogleCallback']);

Route::get('/register/google', [RegisterController::class, 'redirectToGoogle'])->name('register.google');
Route::get('/register/google/callback', [RegisterController::class, 'handleGoogleCallback']);

// =====================
// Search Routes
// =====================
Route::get('/search', [SearchController::class, 'searchPage'])->name('search.page');
Route::get('/api/search', [SearchController::class, 'search'])->name('search.api');
Route::get('/api/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
Route::get('/api/products/filter', [SearchController::class, 'filterByCategory'])->name('products.filter');