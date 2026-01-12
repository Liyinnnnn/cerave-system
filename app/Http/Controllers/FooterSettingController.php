<?php

namespace App\Http\Controllers;

use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
    public function edit()
    {
        $footer = FooterSetting::first();
        return view('admin.footer-settings', compact('footer'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'copyright_text' => 'nullable|string',
        ]);

        $footer = FooterSetting::first();
        if ($footer) {
            $footer->update($validated);
        } else {
            FooterSetting::create($validated);
        }

        return redirect()->back()->with('success', 'Footer settings updated successfully!');
    }
}
