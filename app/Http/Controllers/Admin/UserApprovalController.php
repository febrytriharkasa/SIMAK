<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserApprovalController extends Controller
{
    /**
     * List semua user pending.
     */
    public function index()
    {
       $admins = User::where('role', 'admin')->get(); 
        return view('admin.user-approvals.index', compact('users'));
    }

    /**
     * Approve user → ubah status jadi approved + set password default.
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        // Cek apakah sudah approved
        if ($user->status === 'approved') {
            return redirect()->route('user.approvals.index')
                ->with('info', 'User ini sudah pernah di-approve.');
        }

        $user->status = 'approved';
        $user->password = Hash::make('password123'); // password default
        $user->save();

        // Kirim email pemberitahuan
        try {
            Mail::raw("Akun Anda sudah disetujui. Silakan login dengan password default: password123", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Akun Disetujui - SIMAK');
            });
        } catch (\Exception $e) {
            // Jika email gagal, tetap lanjut
        }

        return redirect()->route('user.approvals.index')
            ->with('success', 'User berhasil di-approve!');
    }

    /**
     * Reject user → ubah status jadi rejected.
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);

        // Cek apakah sudah rejected
        if ($user->status === 'rejected') {
            return redirect()->route('user.approvals.index')
                ->with('info', 'User ini sudah pernah ditolak.');
        }

        $user->status = 'rejected';
        $user->save();

        // Kirim email pemberitahuan
        try {
            Mail::raw("Maaf, registrasi Anda ditolak. Silakan hubungi admin.", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Akun Ditolak - SIMAK');
            });
        } catch (\Exception $e) {
            // Jika email gagal, tetap lanjut
        }

        return redirect()->route('user.approvals.index')
            ->with('error', 'User berhasil ditolak.');
    }
}
