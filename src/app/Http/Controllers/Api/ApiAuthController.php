<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OTPEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApiAuthController extends Controller
{
    /**
     * API Register
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
        ], [
            'email.regex' => 'Format email tidak valid. Pastikan menggunakan domain yang benar (contoh: .com, .id).',
        ]);

        // Check if email already exists
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini telah terdaftar, silakan login.'
            ], 400);
        }

        // Validate the rest of the inputs
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|min:9|max:15|regex:/^\+?[0-9]+$/',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'phone.regex' => 'Nomor HP hanya boleh berisi angka dan diawali dengan + (opsional).',
            'phone.min' => 'Nomor HP minimal 9 karakter.',
            'phone.max' => 'Nomor HP maksimal 15 karakter.',
        ]);

        $otp = rand(1000, 9999);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => Hash::make($request->password),
            'saldo' => 1000000,
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP email
        try {
            Mail::to($user->email)->send(new OTPEmail($otp));
        } catch (\Exception $e) {
            // Keep going even if email fails in local dev environment
        }

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Silakan cek email kamu untuk kode OTP.',
            'email' => $user->email
        ], 201);
    }

    /**
     * API Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:4',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP tidak valid atau sudah kedaluwarsa.'
            ], 400);
        }

        $user->email_verified_at = Carbon::now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Create Sanctum Token for mobile app auth
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil diverifikasi!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    /**
     * API Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'password' => 'required|string',
        ], [
            'email.regex' => 'Format email tidak valid. Pastikan menggunakan domain yang benar (contoh: .com, .id).',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial yang dimasukkan salah.'
            ], 401);
        }

        // Check if email is verified
        if (is_null($user->email_verified_at)) {
            // Resend OTP if needed
            $otp = rand(1000, 9999);
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            try {
                Mail::to($user->email)->send(new OTPEmail($otp));
            } catch (\Exception $e) {}

            return response()->json([
                'success' => false,
                'is_verified' => false,
                'message' => 'Email belum diverifikasi. Kode OTP baru telah dikirim ke email kamu.',
                'email' => $user->email
            ], 403);
        }

        // Generate Sanctum Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    /**
     * API Logout
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to access this route
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil!'
        ], 200);
    }

    /**
     * API Google Login (Untuk Android Studio)
     */
    public function googleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'google_id' => 'required|string', // Pastikan android mengirim ID dari akun Google
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Update google_id jika belum ada
            if (is_null($user->google_id)) {
                $user->google_id = $request->google_id;
                $user->save();
            }
            
            // Jika user ada tapi belum verifikasi email, anggap verifikasi sudah lewat google
            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
        } else {
            // Jika belum ada, buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'google_id' => $request->google_id, // Simpan ID google
                'saldo' => 1000000,
                'password' => Hash::make(uniqid()), // Berikan password acak
                'email_verified_at' => Carbon::now(), // Langsung terverifikasi
            ]);
        }

        // Buat Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Google berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }
}
