<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get 4 latest products (most recently created)
        $latestProducts = Product::active()
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('beranda', compact('latestProducts'));
    }
}