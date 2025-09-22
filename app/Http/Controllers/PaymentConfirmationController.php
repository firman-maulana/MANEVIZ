<?php

namespace App\Http\Controllers;

use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;


class PaymentConfirmationController extends Controller
{
    /**
     * Display the payment confirmation form
     */
    public function index(): View
    {
        return view('paymentConfirmation');
    }

    /**
     * Store a new payment confirmation
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'order_id' => 'required|string|max:255',
            'total_transfer' => 'required|numeric|min:0',
            'transfer_to' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Clean up total_transfer (remove any formatting)
        $validated['total_transfer'] = str_replace(['Rp', '.', ',', ' '], '', $validated['total_transfer']);
        $validated['total_transfer'] = (float) $validated['total_transfer'];

        try {
            $paymentConfirmation = PaymentConfirmation::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Payment confirmation submitted successfully! We will process your order shortly.',
                'data' => [
                    'id' => $paymentConfirmation->id,
                    'order_id' => $paymentConfirmation->order_id,
                    'status' => $paymentConfirmation->status,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit payment confirmation. Please try again.',
                'errors' => ['general' => ['An error occurred while processing your request.']]
            ], 500);
        }
    }

    /**
     * Check payment confirmation status
     */
    public function checkStatus(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|string'
        ]);

        $confirmation = PaymentConfirmation::where('order_id', $request->order_id)->first();

        if (!$confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'Payment confirmation not found for this order ID.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_id' => $confirmation->order_id,
                'status' => $confirmation->status,
                'status_label' => $confirmation->status_label,
                'total_transfer' => $confirmation->formatted_total_transfer,
                'bank_name' => $confirmation->bank_name,
                'created_at' => $confirmation->created_at->format('d M Y H:i'),
                'verified_at' => $confirmation->verified_at?->format('d M Y H:i'),
                'admin_notes' => $confirmation->admin_notes,
            ]
        ]);
    }
}