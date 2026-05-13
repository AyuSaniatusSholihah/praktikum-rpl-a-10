<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        return back()->with('status', 'Akun berhasil divalidasi. Logika simpan user belum ditambahkan.');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function redirectGoogle(): RedirectResponse
    {
        return back()->withErrors(['google' => 'Integrasi Google belum dikonfigurasi.']);
    }

    public function redirectEmail(): RedirectResponse
    {
        return back();
    }
}
