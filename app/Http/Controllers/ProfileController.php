<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $products = Product::orderBy('name')->get();
        return view('profile.edit', [
            'user' => $request->user(),
            'products' => $products
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::exists('profile_pictures/' . $user->profile_picture)) {
                Storage::delete('profile_pictures/' . $user->profile_picture);
            }

            $image = $request->file('profile_picture');
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_pictures', $filename);
            $user->profile_picture = $filename;
        }

        // Detect email change
        $emailChanged = isset($data['email']) && $data['email'] !== $user->email;

        // Update other profile fields
        $user->fill([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'phone' => $data['phone'] ?? null,
            'country_code' => $data['country_code'] ?? '+60',
        ]);

        // If email changed, mark as unverified and send verification email
        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Send Laravel's standard verification email to the new address
        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
            
            return redirect()->route('verification.notice')
                ->with('status', 'verification-link-sent');
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully.')
            ->with('form', 'profile');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password updated successfully.')
            ->with('form', 'password');
    }

    public function setPassword(Request $request): RedirectResponse
    {
        // Allow setting a password without current password only if user doesn't have one
        if (!is_null($request->user()->password)) {
            return redirect()->route('profile.edit')->with('error', 'You already have a password set.');
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password created successfully. You can now sign in using email + password or Google.')
            ->with('form', 'password');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateSkincare(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'skin_type' => ['nullable', 'string', 'in:Normal,Dry,Oily,Combination,Sensitive'],
            'skin_concerns' => ['nullable', 'string', 'max:1000'],
            'skin_conditions' => ['nullable', 'string', 'max:1000'],
            'using_products' => ['nullable', 'array'],
            'using_products.*' => ['integer', 'exists:products,id'],
        ]);

        $user = $request->user();
        $user->skin_type = $validated['skin_type'] ?? null;
        $user->skin_concerns = $validated['skin_concerns'] ?? null;
        $user->skin_conditions = $validated['skin_conditions'] ?? null;
        $user->using_products = $validated['using_products'] ?? [];
        $user->skincare_profile_updated_at = now();
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Skincare profile updated successfully.')
            ->with('form', 'skincare');
    }
}
