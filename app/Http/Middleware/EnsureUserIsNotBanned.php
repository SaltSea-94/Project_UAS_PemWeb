<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_banned) {
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akun ditangguhkan. Menunggu keputusan Admin.'], 403);
            }

            if ($request->is('marinulis*')) {
                return redirect()->route('home')->with('error', 'AKSES DITOLAK: Akun Anda sedang dibekukan. Mohon tunggu keputusan Admin untuk memulihkan akses menulis Anda.');
            }

            return back()->with('error', 'AKSES DITOLAK: Status akun Anda sedang ditangguhkan. Segala aktivitas interaksi dibatasi hingga ada keputusan pembukaan blokir dari Admin.');
        }

        return $next($request);
    }
}