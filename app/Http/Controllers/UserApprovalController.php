<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    // Tampilkan semua user yang masih pending
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        return view('admin.user-approvals.index', compact('pendingUsers'));
    }

    // Approve user
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return redirect()->route('user.approvals.index')->with('success', 'User berhasil di-approve!');
    }

    // Reject user
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected'; // bisa juga pakai delete kalau mau hapus
        $user->save();

        return redirect()->route('user.approvals.index')->with('error', 'User ditolak!');
    }
}
