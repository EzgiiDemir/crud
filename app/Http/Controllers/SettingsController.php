<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // Kullanıcıyı al
        $settings = json_decode($user->settings, true) ?? ['notifications' => 'enabled', 'theme' => 'light']; // Ayarları al, yoksa varsayılan ayarları kullan
        return view('products.settings', compact('settings')); // Ayarları view'a gönder
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // Kullanıcıyı al

        // Gelen ayarları güncelle
        $user->settings = json_encode([
            'notifications' => $request->notifications, // E-posta bildirim durumu
            'theme' => $request->theme // Tema durumu
        ]);

        // Kullanıcıyı kaydet
        $user->save();

        // Başarı mesajı ile ayar sayfasına yönlendir
        return redirect()->route('settings')->with('success', 'Settings updated successfully.');
    }
}
