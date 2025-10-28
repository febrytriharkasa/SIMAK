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

        // Update field teks
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;

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
        if ($user->foto) {
            return response($user->foto)->header('Content-Type', 'image/jpeg');
        }

        return redirect('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=435ebe&color=fff');
    }
}
