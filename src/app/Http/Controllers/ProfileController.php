<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function index()
    {
        return view('profile.ProfileMenuPage', ['user' => Auth::user()]);
    }

    // Simpan perubahan profil ke database
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'username'     => 'nullable|string|max:100|unique:users,username,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'alamat'       => 'nullable|string|max:255',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password'     => 'nullable|string|min:8|confirmed',
        ], [
            'foto_profil.image' => 'File harus berupa gambar (jpeg, png, jpg, webp).',
            'foto_profil.max'   => 'Ukuran foto maksimal 2 MB.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name'         => $validated['name'],
            'username'     => $validated['username'] ?? $user->username,
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
            'alamat'       => $validated['alamat'] ?? $user->alamat,
        ];

        // Ganti password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Upload foto profil baru (hapus yang lama jika ada)
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
