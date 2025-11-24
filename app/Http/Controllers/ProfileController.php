<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash; // ✅ tambahkan
use Carbon\Carbon; // ✅ tambahkan
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function edit(): View
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update semua field
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->agama = $request->agama;
        $user->alamat = $request->alamat;
        $user->mata_pelajaran = $request->mata_pelajaran;
        $user->kelas_diampu = $request->kelas_diampu;
        $user->jabatan = $request->jabatan;
        $user->tanggal_masuk = $request->tanggal_masuk;
        $user->pendidikan = $request->pendidikan;
        $user->status_kepegawaian = $request->status_kepegawaian;

        // Update foto kalau ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $user->foto = file_get_contents($file->getRealPath());
        }

        $user->save();

        return Redirect::route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }


    // ✅ Update password via popup
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return Redirect::back()->with('error', 'Password lama salah!');
        }

        $user->password = Hash::make($request->new_password);
        $user->last_password_changed_at = Carbon::now(); // ✅ Simpan waktu terakhir ganti password
        $user = Auth::user();

        return Redirect::back()->with('success', 'Password berhasil diganti!');
    }

    public function avatar($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Jika ada foto di database → tampilkan
        if ($user->foto) {
            return response($user->foto)
                ->header('Content-Type', 'image/jpeg');
        }

        // Jika tidak ada foto → tampilkan avatar default lokal (bukan redirect)
        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->name)
                    . '&background=435ebe&color=fff';

        // Ambil gambar dari internet lalu kirim ke browser
        $image = file_get_contents($avatarUrl);

        return response($image)
            ->header('Content-Type', 'image/png');
    }

}