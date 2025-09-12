<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->status !== 'approved') {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Akun Anda belum disetujui admin atau ditolak.');
        }

        return $next($request);
    }
}
