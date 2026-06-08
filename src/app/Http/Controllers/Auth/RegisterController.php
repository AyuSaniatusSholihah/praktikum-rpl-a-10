<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OTPEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
        ], [
            'email.regex' => 'Format email tidak valid. Pastikan menggunakan domain yang benar (contoh: .com, .id).',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return redirect()->route('login')->with('warning', 'Akun ini telah terdaftar, silahkan login.');
        }

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

        Mail::to($user->email)->send(new OTPEmail($otp));

        return redirect()->route('otp.verify', ['email' => $user->email])
            ->with('success', 'Registration successful! Please check your email for the OTP code.');
    }

    public function showOtpForm(Request $request)
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|array|size:4',
            'otp.*' => 'required|string|size:1',
        ]);

        $otpCode = implode('', $request->otp);

        $user = User::where('email', $request->email)
            ->where('otp_code', $otpCode)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }

        $user->email_verified_at = Carbon::now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Akun berhasil diverifikasi! Silakan login untuk melanjutkan.');
    }
}
