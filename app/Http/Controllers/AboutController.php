<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Ambil konten aktif, jika tidak ada ambil yang terbaru
        $about = AboutContent::active()->first() ?? AboutContent::latest()->first();

        return view('about', compact('about'));
    }
}
