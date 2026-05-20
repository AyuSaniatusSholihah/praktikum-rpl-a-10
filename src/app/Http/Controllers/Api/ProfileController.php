<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Lihat profil sendiri
    public function show(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }

    // Edit profil sendiri (Gunakan POST + _method=PUT atau murni POST untuk form-data)
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'sometimes|string|max:100',
            'username' => 'sometimes|string|max:100|unique:users,username,' . $user->id,
            'phone_number' => 'sometimes|string|min:9|max:15|regex:/^\+?[0-9]+$/',
            'alamat' => 'nullable|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'phone_number.regex' => 'Nomor HP hanya boleh berisi angka dan diawali dengan + (opsional).',
            'phone_number.min' => 'Nomor HP minimal 9 karakter.',
            'phone_number.max' => 'Nomor HP maksimal 15 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $validated['foto_profil'] = $path;
        }

        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }
}
