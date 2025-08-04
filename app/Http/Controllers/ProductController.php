<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Method lainnya...
    
    public function show($id)
    {
        // Logic untuk mengambil data produk berdasarkan ID
        // Contoh data dummy:
        $products = [
            'muzan-tshirt' => [
                'name' => 'Muzan T-Shirt',
                'price' => 'IDR 50,000.00',
                'image' => 'storage/image/produk1.jpg'
            ],
            'douma-tshirt' => [
                'name' => 'Douma T-Shirt',
                'price' => 'IDR 50,000.00', 
                'image' => 'storage/image/produk2.jpg'
            ],
            // dst...
        ];
        
        $product = $products[$id] ?? null;
        
        if (!$product) {
            abort(404);
        }
        
        return view('product.detail', compact('product'));
    }
}