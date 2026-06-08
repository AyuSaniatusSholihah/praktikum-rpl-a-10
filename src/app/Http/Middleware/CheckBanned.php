<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    /**
     * Cek apakah user yang sedang login ter-ban.
     * Jika iya, logout paksa dan redirect ke login dengan pesan error.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_banned) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun kamu telah dinonaktifkan. Hubungi admin untuk informasi lebih lanjut.',
            ]);
        }

        return $next($request);
    }
}
