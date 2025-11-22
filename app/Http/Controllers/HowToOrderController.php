<?php

namespace App\Http\Controllers;

use App\Models\HowToOrderStep;
use Illuminate\Http\Request;

class HowToOrderController extends Controller
{
    /**
     * Display the how to order page
     */
    public function index()
    {
        $steps = HowToOrderStep::active()
            ->ordered()
            ->get();

        return view('howToOrder', compact('steps'));
    }
}
