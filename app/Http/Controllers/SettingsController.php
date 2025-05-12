<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $settings = json_decode($user->settings, true) ?? [
            'notifications' => 'enabled',
            'theme' => 'light',
        ];

        return view('products.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'notifications' => 'required|in:enabled,disabled',
            'theme' => 'required|in:light,dark',
        ], [
            'notifications.required' => 'Notification setting is required.',
            'notifications.in' => 'Notification setting must be either "enabled" or "disabled".',
            'theme.required' => 'Theme selection is required.',
            'theme.in' => 'Theme must be either "light" or "dark".',
        ]);

        $user = Auth::user();

        $user->settings = json_encode([
            'notifications' => $request->notifications,
            'theme' => $request->theme,
        ]);

        $user->save();

        return redirect()->route('settings')->with('success', 'Settings updated successfully.');
    }
}
