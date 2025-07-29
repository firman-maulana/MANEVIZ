<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\DependencyInjection\RegisterControllerArgumentLocatorsPass;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('beranda');
});


Route::get('/allProduct', function () {
    return view('allProduk');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/refundPolicy', function () {
    return view('refundPolicy');
});

Route::get('/howToOrder', function () {
    return view('howToOrder');
});

Route::get('/paymentConfirmation', function () {
    return view('paymentConfirmation');
});


// Auth Routes
Route::get('/signUp', [RegisterController::class, 'showsignUpForm'])->name('signUp');
Route::post('/signUp', [RegisterController::class, 'signUp']);
Route::get('/signIn', [AuthController::class, 'showsignInForm'])->name('signIn');
Route::post('/signIn', [AuthController::class, 'signIn']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
