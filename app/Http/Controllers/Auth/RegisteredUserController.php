<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'name'  => ['required', 'string', 'max:255'],
            'nip'   => ['required', 'string', 'max:50', 'unique:users,nip'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'  => ['required', 'in:guru_tk,guru_mi'],
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'nip'      => $request->nip,
            'email'    => $request->email,
            'status'   => 'pending',                // default pending
            'role'     => $request->role ?? null,   // kalau pakai kolom role di users
            'password' => Hash::make('temporary'),  // password default sementara
        ]);
        
        $user->assignRole($request->role);
        /**
         * =============== OPSI ROLE ===============
         * Kalau kamu pakai Spatie/Permission, aktifkan baris ini
         *
         * Kalau kamu cuma pakai kolom "role" di tabel users, 
         * cukup biarkan yang atas (role disimpan langsung).
         * =========================================
         */

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Menunggu persetujuan admin.');
    }
}
