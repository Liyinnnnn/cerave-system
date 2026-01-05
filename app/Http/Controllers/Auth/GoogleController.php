<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        \Log::info('Google OAuth redirect hit');
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback(): RedirectResponse
    {
        \Log::info('Google OAuth callback hit');
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);

        if (!$user->exists) {
            $user->fill([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'nickname' => $googleUser->getNickname(),
                'password' => Str::random(32),
                'role' => 'consumer',
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'email_verified_at' => now(),
            ])->save();
        } else {
            $user->fill([
                'nickname' => $user->nickname ?: $googleUser->getNickname(),
                'provider' => $user->provider ?: 'google',
                'provider_id' => $user->provider_id ?: $googleUser->getId(),
            ]);

            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
            }

            if (empty($user->password)) {
                $user->password = Str::random(32);
            }

            $user->save();
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }
}
