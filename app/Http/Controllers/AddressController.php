<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAddress;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display listing of user addresses
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('address.index', compact('addresses'));
    }

    /**
     * Show form for creating new address
     */
    public function create()
    {
        return view('address.create');
    }

    /**
     * Store new address
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:50',
            'recipient_name' => 'required|string|max:255',
            // 'phone' => 'required|string|max:20', // Dihapus - menggunakan phone dari user
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'notes' => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // If this is the first address, make it default
        if (UserAddress::where('user_id', Auth::id())->count() === 0) {
            $data['is_default'] = true;
        }

        $address = UserAddress::create($data);

        // If set as default, unset others
        if ($request->is_default) {
            $address->setAsDefault();
        }

        // Check if this was called from checkout (via AJAX or popup)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil ditambahkan!',
                'address' => [
                    'id' => $address->id,
                    'label' => $address->label,
                    'recipient_name' => $address->recipient_name,
                    'address' => $address->address,
                    'city' => $address->city,
                    'province' => $address->province,
                    'postal_code' => $address->postal_code,
                    'is_default' => $address->is_default,
                    'full_address' => $address->full_address
                ]
            ]);
        }

        return redirect()->route('address.index')
            ->with('success', 'Alamat berhasil ditambahkan!');
    }

    /**
     * Show form for editing address
     */
    public function edit(UserAddress $address)
    {
        // Ensure user can only edit their own address
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('address.edit', compact('address'));
    }

    /**
     * Update address
     */
    public function update(Request $request, UserAddress $address)
    {
        // Ensure user can only update their own address
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'label' => 'nullable|string|max:50',
            'recipient_name' => 'required|string|max:255',
            // 'phone' => 'required|string|max:20', // Dihapus
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'notes' => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        $address->update($request->all());

        // If set as default, unset others
        if ($request->is_default) {
            $address->setAsDefault();
        }

        // Check if this was called via AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil diperbarui!',
                'address' => [
                    'id' => $address->id,
                    'label' => $address->label,
                    'recipient_name' => $address->recipient_name,
                    'address' => $address->address,
                    'city' => $address->city,
                    'province' => $address->province,
                    'postal_code' => $address->postal_code,
                    'is_default' => $address->is_default,
                    'full_address' => $address->full_address
                ]
            ]);
        }

        return redirect()->route('address.index')
            ->with('success', 'Alamat berhasil diperbarui!');
    }

    /**
     * Delete address
     */
    public function destroy(UserAddress $address)
    {
        // Ensure user can only delete their own address
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if this is the default address
        $isDefault = $address->is_default;

        $address->delete();

        // If deleted address was default, set another one as default
        if ($isDefault) {
            $nextAddress = UserAddress::where('user_id', Auth::id())->first();
            if ($nextAddress) {
                $nextAddress->setAsDefault();
            }
        }

        // Check if this was called via AJAX
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil dihapus!'
            ]);
        }

        return redirect()->route('address.index')
            ->with('success', 'Alamat berhasil dihapus!');
    }

    /**
     * Set address as default
     */
    public function setDefault(UserAddress $address)
    {
        // Ensure user can only modify their own address
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $address->setAsDefault();

        // Check if this was called via AJAX
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat utama berhasil diperbarui!'
            ]);
        }

        return redirect()->route('address.index')
            ->with('success', 'Alamat utama berhasil diperbarui!');
    }

    /**
     * Get addresses for AJAX requests (for checkout page)
     */
    public function getAddresses()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'addresses' => $addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'label' => $address->label,
                    'recipient_name' => $address->recipient_name,
                    'address' => $address->address,
                    'city' => $address->city,
                    'province' => $address->province,
                    'postal_code' => $address->postal_code,
                    'is_default' => $address->is_default,
                    'full_address' => $address->full_address,
                    'phone' => $address->phone
                ];
            })
        ]);
    }
}