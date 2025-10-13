<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // ✅ Import Role

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('user.index', compact('users'));
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('password'); 
        $user->save();

        return redirect()->route('users.index')->with('success', 'Password user berhasil direset ke: password');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // ✅ ambil semua role
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'roles' => 'nullable|array'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // ✅ Update roles user
        if ($request->roles) {
            $user->syncRoles($request->roles); // hapus role lama, ganti dengan role baru
        } else {
            $user->roles()->detach(); // jika kosong, hapus semua role
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
