<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetPasswordOTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/']
        ], [
            'email.exists' => 'Email ini belum terdaftar di sistem kami.',
            'email.regex' => 'Format email tidak valid. Pastikan menggunakan domain yang benar (contoh: .com, .id).',
        ]);

        $otp = rand(1000, 9999);
        $user = User::where('email', $request->email)->first();

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new ResetPasswordOTPMail($otp));

        return redirect()->route('password.otp', ['email' => $user->email])
            ->with('success', 'OTP code sent to your email.');
    }

    public function showOtpForm(Request $request)
    {
        return view('auth.reset-password-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'otp' => 'required|array|size:4',
            'otp.*' => 'required|string|size:1',
        ], [
            'email.regex' => 'Format email tidak valid. Pastikan menggunakan domain yang benar (contoh: .com, .id).',
        ]);

        $otpCode = implode('', $request->otp);

        $user = User::where('email', $request->email)
            ->where('otp_code', $otpCode)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }

        return redirect()->route('password.reset', ['email' => $request->email, 'code' => $otpCode])
            ->with('success', 'OTP verified. You can now reset your password.');
    }

    public function showResetForm(Request $request)
    {
        // Verify OTP again to prevent direct access
        $user = User::where('email', $request->email)
            ->where('otp_code', $request->code)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Invalid request.']);
        }

        return view('auth.reset-password', ['email' => $request->email, 'code' => $request->code]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'code' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.regex' => 'Format email tidak valid. Pastikan menggunakan domain yang benar (contoh: .com, .id).',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->code)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Invalid request or expired session.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('login')->with('success', 'Password reset successful! Please login with your new password.');
    }
}
