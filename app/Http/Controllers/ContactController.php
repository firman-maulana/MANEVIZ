<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'subject' => ['required', Rule::in(['general', 'support', 'sales', 'partnership', 'other'])],
            'message' => 'required|string',
        ]);

        try {
            Contact::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your message has been sent successfully! We will get back to you soon.'
                ]);
            }

            return redirect()->back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, there was an error sending your message. Please try again.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }
}