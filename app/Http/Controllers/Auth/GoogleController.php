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
        \Log::info('=== GOOGLE REDIRECT ROUTE HIT ===');
        try {
            \Log::info('Google OAuth redirect attempt - CLIENT_ID: ' . config('services.google.client_id'));
            \Log::info('Calling Socialite::driver(google)->stateless()->redirect()');
            $redirectUrl = Socialite::driver('google')->stateless()->redirect();
            \Log::info('Redirect URL generated successfully, redirecting to Google');
            return $redirectUrl;
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
            \Log::info('=== GOOGLE CALLBACK STARTED ===');
            $googleUser = Socialite::driver('google')->stateless()->user();
            \Log::info('Got Google user: ' . $googleUser->getEmail());
        } catch (\Exception $e) {
            \Log::error('Google OAuth callback failed: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Google authentication failed. Please try again.');
        }

        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);

        if (!$user->exists) {
            \Log::info('Creating new user from Google OAuth');
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
            \Log::info('Updating existing user from Google OAuth');
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

        \Log::info('About to call Auth::login for user: ' . $user->email);
        Auth::login($user, true);
        \Log::info('Auth::login called. Session ID: ' . session()->getId());
        \Log::info('User authenticated: ' . Auth::check());

        return redirect()->intended('/dashboard');
    }
}
