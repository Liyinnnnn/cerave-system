<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'nickname' => $googleUser->getNickname(),
                'email' => $googleUser->getEmail(),
                'password' => null, // No password set yet for OAuth users
                'role' => 'consumer',
                // mark email verified since Google confirms ownership
                'email_verified_at' => now(),
            ]);
        } else {
            // ensure email verified if logging in via Google
            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
                $user->save();
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }
}
