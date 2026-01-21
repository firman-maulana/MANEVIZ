<?php

namespace App\Http\Controllers;

use App\Models\RefundPolicy;
use Illuminate\Http\Request;

class RefundPolicyController extends Controller
{
    public function index()
    {
        $policies = RefundPolicy::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->groupBy('section_key');

        return view('refundPolicy', compact('policies'));
    }
}
