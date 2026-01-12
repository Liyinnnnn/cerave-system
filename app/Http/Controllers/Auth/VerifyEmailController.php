<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // If user has no password, redirect to profile to set password
            if (is_null($request->user()->password)) {
                return redirect()->route('profile.edit')->with('status', 'email-verified');
            }
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // After verification, check if user needs to set password
        if (is_null($request->user()->password)) {
            return redirect()->route('profile.edit')->with('status', 'email-verified');
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
