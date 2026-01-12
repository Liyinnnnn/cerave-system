<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\FooterSetting;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    use ResponseHelper;

    /**
     * Show admin panel for front page settings.
     */
    public function index()
    {
        try {
            if (!auth()->user()->isAdmin()) {
                return $this->unauthorized('Only admins can manage settings.');
            }

            $settings = [
                'front_page_title' => Setting::get('front_page_title', 'Skincare Developed with Dermatologists'),
                'front_page_description' => Setting::get('front_page_description', 'Experience the power of ceramides with dermatologist-developed formulations for healthy, beautiful skin backed by science.'),
                'site_name' => Setting::get('site_name', 'CeraVe'),
                'tagline' => Setting::get('tagline', 'Dermatologist-Recommended Skincare'),
            ];

            $footer = FooterSetting::first();

            return view('admin.settings', compact('settings', 'footer'));
        } catch (\Exception $e) {
            \Log::error('Admin settings load failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load settings.', 'ERR_SETTINGS_LOAD');
        }
    }

    /**
     * Update front page settings.
     */
    public function update(Request $request)
    {
        try {
            if (!auth()->user()->isAdmin()) {
                return $this->unauthorized('Only admins can manage settings.');
            }

            $validated = $request->validate([
                'front_page_title' => 'required|string|max:255',
                'front_page_description' => 'required|string|max:1000',
                'site_name' => 'required|string|max:255',
                'tagline' => 'required|string|max:255',
            ]);

            foreach ($validated as $key => $value) {
                Setting::set($key, $value);
            }

            return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Admin settings update failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to update settings.', 'ERR_SETTINGS_UPDATE');
        }
    }
}
