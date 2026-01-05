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
        
        \Log::info('Google user data', ['email' => $googleUser->getEmail(), 'id' => $googleUser->getId()]);

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
            \Log::info('New user created', ['id' => $user->id, 'email' => $user->email]);
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
            \Log::info('Existing user updated', ['id' => $user->id, 'email' => $user->email]);
        }

        Auth::login($user, true);
        \Log::info('User authenticated', ['user_id' => Auth::id(), 'authenticated' => Auth::check()]);
        
        // Explicitly save session to ensure authentication persists
        request()->session()->save();
        
        $sessionId = request()->session()->getId();
        \Log::info('Session saved', ['session_id' => $sessionId, 'cookie_name' => config('session.cookie')]);

        return redirect()->intended('/dashboard');
    }
}
