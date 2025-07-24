<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showsignUpForm(): View
    {
        return view('auth.signUp');
    }

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'phone'      => 'nullable|string|max:20',
            'gender'     => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
        ]);

        // Create user dengan hanya field yang ada di database
        $userData = [
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        // Tambahkan field opsional hanya jika ada
        if (!empty($validated['phone'])) {
            $userData['phone'] = $validated['phone'];
        }

        if (!empty($validated['gender'])) {
            $userData['gender'] = $validated['gender'];
        }

        if (!empty($validated['birth_date'])) {
            $userData['birth_date'] = $validated['birth_date'];
        }

        try {
            $user = User::create($userData);
            Auth::login($user);

            return redirect('/beranda')->with('success', 'Selamat datang di MANEVIZ! Akun Anda berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.'])->withInput();
        }
    }
}