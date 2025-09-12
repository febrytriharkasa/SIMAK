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
            'nip'   => ['required', 'string', 'max:50', 'unique:users,nip'],
            'name'  => ['required', 'string', 'max:255'], // jabatan
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'  => ['required', 'in:guru_tk,guru_mi'], 
        ]);

        // Simpan user dengan status pending, tanpa password
        User::create([
            'nip'    => $request->nip,
            'name'   => $request->name,
            'email'  => $request->email,
            'role'   => $request->role,
            'status' => 'pending',
            'password' => bcrypt('temporary'), // sementara
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Menunggu persetujuan admin.');
    }
}
