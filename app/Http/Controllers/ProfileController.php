<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit(): View
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Simpan foto ke DB sebagai BLOB
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $data['foto'] = file_get_contents($file->getRealPath());
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('profile.show')->with('status', 'account-deleted');
    }

    // Route untuk menampilkan foto
    public function avatar($id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->foto) {
            return response($user->foto)->header('Content-Type', 'image/jpeg');
        }
        return response()->file(public_path('default-avatar.png'));
    }
}
