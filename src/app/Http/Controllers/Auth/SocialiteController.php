<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function callback()
    {
        $socialUser = Socialite::driver('google')->stateless()->user();

        // 1. Try to find user by google_id
        $user = User::where('google_id', $socialUser->id)->first();

        if ($user) {
            // User exists with this Google account, update tokens
            $user->update([
                'google_token' => $socialUser->token,
                'google_refresh_token' => $socialUser->refreshToken,
            ]);
        } else {
            // 2. Not found by google_id, try to find by email
            $user = User::where('email', $socialUser->email)->first();

            if ($user) {
                // User exists with this email, link the Google ID
                $user->update([
                    'google_id' => $socialUser->id,
                    'google_token' => $socialUser->token,
                    'google_refresh_token' => $socialUser->refreshToken,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // 3. Not found by either, create new user
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make(Str::random(24)),
                    'saldo' => 1000000,
                    'google_id' => $socialUser->id,
                    'google_token' => $socialUser->token,
                    'google_refresh_token' => $socialUser->refreshToken,
                    'email_verified_at' => now(),
                ]);
            }
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}
