<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class UserApprovalController extends Controller
{
    /**
     * List semua user pending.
     */
    public function index()
    {
        // Ambil semua user non-admin
        $users = User::where('role', '!=', 'admin')
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->get();

        return view('admin.user-approvals.index', compact('users'));
    }

    /**
     * Approve user → ubah status jadi approved + set password default.
     */
    public function approve($id)
{
        $user = User::findOrFail($id);

        if ($user->status === 'approved') {
            return redirect()->route('user.approvals.index')
                ->with('info', 'User ini sudah pernah di-approve.');
        }

        $user->status = 'approved';
        $defaultPassword = env('DEFAULT_USER_PASSWORD', 'password123');
        $user->password = Hash::make($defaultPassword);
        $user->save();

        // Kirim email pemberitahuan password default
        try {
            Mail::raw(
                "Akun Anda sudah disetujui oleh admin SIMAK.\n\nSilakan login dengan email: {$user->email}\nPassword default Anda: {$defaultPassword}\n\nSegera ganti password setelah login.",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Akun SIMAK Disetujui & Password Default');
                }
            );
        } catch (\Exception $e) {
            // Jika email gagal, tetap lanjut
        }

        return redirect()->route('user.approvals.index')
            ->with('success', 'User berhasil di-approve dan email sudah dikirim!');
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
            Mail::raw(
                "Maaf, registrasi Anda ditolak. Silakan hubungi admin.",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Akun Ditolak - SIMAK');
                }
            );
        } catch (\Exception $e) {
            // Jika email gagal, tetap lanjut
        }

        return redirect()->route('user.approvals.index')
            ->with('error', 'User berhasil ditolak.');
    }
}