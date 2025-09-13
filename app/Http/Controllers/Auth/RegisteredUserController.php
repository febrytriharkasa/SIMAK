<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form registrasi
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Simpan data registrasi (status = pending)
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'], // nama user
            'nip'   => ['required', 'string', 'max:50', 'unique:users,nip'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'  => ['required', 'in:guru_tk,guru_mi'], 
        ]);

        // Simpan user dengan status pending, password sementara
        User::create([
            'name'   => $request->name,
            'nip'    => $request->nip,
            'email'  => $request->email,
            'role'   => $request->role,
            'status' => 'pending',
            'password' => bcrypt('temporary'), // akan diganti saat approve
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Menunggu persetujuan admin.');
    }
}
