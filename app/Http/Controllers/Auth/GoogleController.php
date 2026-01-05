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
        try {
            \Log::info('Google OAuth redirect attempt - CLIENT_ID: ' . config('services.google.client_id'));
            return Socialite::driver('google')->stateless()->redirect();
        } catch (\Exception $e) {
            \Log::error('Google OAuth redirect FAILED', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/login')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            \Log::error('Google OAuth callback failed: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Google authentication failed. Please try again.');
        }

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
