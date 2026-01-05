<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrangtuaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.ortu-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        // auth untuk guard ortu
        if (Auth::guard('ortu')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('ortu.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('ortu')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('ortu.login');
    }
}
