<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input termasuk role
        $request->validate([
            'name'  => ['required', 'string', 'max:255'], // nama user
            'nip'   => ['required', 'string', 'max:50', 'unique:users,nip'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:admin,guru_tk,guru_mi'], // validasi role
        ]);

        // Buat user baru
        $user = User::create([
            'name'   => $request->name,
            'nip'    => $request->nip,
            'email'  => $request->email,
            'status' => 'pending',
            'password' => bcrypt('temporary'), // akan diganti saat approve
        ]);

        // Assign role langsung (pastikan Spatie Roles & Permissions sudah terpasang)
        $user->assignRole($request->role);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Menunggu persetujuan admin.');
    }
}
