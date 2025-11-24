<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Form forgot password
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    // Submit request user
    public function submitRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        PasswordResetRequest::create([
            'user_id' => $user->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Request reset password berhasil dikirim. Tunggu approval admin.');
    }

    // Admin: lihat request
    public function adminIndex()
    {
        $requests = PasswordResetRequest::with('user')->orderBy('created_at','desc')->get();

        // Update status expired jika lebih dari 24 jam
        foreach($requests as $req){
            if($req->status == 'pending' && $req->created_at->diffInHours(now()) > 24){
                $req->update(['status' => 'expired']);
            }
        }

        $requests = PasswordResetRequest::with('user')->orderBy('created_at','desc')->get();
        return view('admin.password-requests', compact('requests'));
    }

    // Admin approve request
    public function approveRequest($id)
    {
        $request = PasswordResetRequest::findOrFail($id);

        // Cek status
        if($request->status != 'pending'){
            return back()->with('error', 'Request ini tidak bisa di-approve. Status: '.$request->status);
        }

        // Cek expired 24 jam
        if($request->created_at->diffInHours(now()) > 24){
            $request->update(['status' => 'expired']);
            return back()->with('error', 'Request sudah kadaluarsa.');
        }

        // Generate password baru
        $newPassword = Str::random(8);
        $request->update([
            'status' => 'approved',
            'new_password' => $newPassword
        ]);

        // Update password user
        $user = $request->user;
        $user->password = Hash::make($newPassword);
        $user->save();

        // Kirim email ke user
        Mail::raw("Password baru Anda: $newPassword", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Baru Anda');
        });

        return back()->with('success', 'Password user telah di-reset dan dikirim.');
    }

    // Admin reject request
    public function rejectRequest($id)
    {
        $request = PasswordResetRequest::findOrFail($id);

        if($request->status != 'pending'){
            return back()->with('error', 'Request ini tidak bisa ditolak. Status: '.$request->status);
        }

        $request->update(['status' => 'rejected']);
        return back()->with('error', 'Request reset password ditolak.');
    }
}