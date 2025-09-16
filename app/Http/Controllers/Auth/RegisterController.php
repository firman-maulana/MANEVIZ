<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users; // Menggunakan Users
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    public function showsignUpForm()
    {
        return view('auth.register');
    }

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // ⭐ HANYA buat customer di tabel users
            $user = Users::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer', // ⭐ PASTI customer
                'is_active' => true,
            ]);

            Auth::guard('web')->login($user);

            return redirect('/')->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat membuat akun.'])
                ->withInput();
        }
    }

    // Google OAuth methods tetap sama...
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = Users::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = Users::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()),
                    'role' => 'customer', // ⭐ PASTI customer
                    'is_active' => true,
                ]);
            }

            Auth::guard('web')->login($user);

            return redirect('/')->with('success', 'Login menggunakan Google berhasil. Selamat datang, ' . $user->name . '!');
        } catch (\Exception $e) {
            return redirect('/signUp')->withErrors(['error' => 'Gagal login dengan Google.']);
        }
    }
}