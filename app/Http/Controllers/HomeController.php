<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\BerandaImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index()
{
    // Get 4 latest products
    $latestProducts = Product::active()
        ->with(['category', 'images'])
        ->orderBy('created_at', 'desc')
        ->limit(4)
        ->get();

    // Get carousel images
    $carouselImages = BerandaImage::carousel()->get();

    // Get banner image (Most Culture section)
    $bannerImage = BerandaImage::banner()->first(); // <-- PERBAIKAN

    return view('beranda', compact('latestProducts', 'carouselImages', 'bannerImage'));
}

}