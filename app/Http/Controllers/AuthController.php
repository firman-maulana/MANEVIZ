<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showsignInForm(): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect('/beranda');
        }

        return view(view: 'auth.login');
    }

    public function signIn(Request $request): RedirectResponse
    {
        $credentials = $request->validate(rules: [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if(Auth::attempt(credentials: ['email' => $credentials['email'], 'password' => $credentials['password'], 'is_active' => 1])) {
            $request->session()->regenerate();

            return redirect(to: '/beranda')->with(key: 'success', value: 'Selamat Datang.');
        }

        return back()->withErrors(provider: [
            'email' => 'Email atau password salah',
        ])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(to: '/')->with(key: 'success', value: 'Anda berhasil');
    }
}

?>