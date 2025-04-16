<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // EKLENDİ
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('products/login');  // Login formunu döndür (yolu gerektiği gibi ayarla)
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Bu e-posta adresi sistemde kayıtlı değil.'])
                ->withInput();
        }

        if (!\Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Şifre yanlış.'])
                ->withInput();
        }

        // Giriş başarılıysa:
        Auth::login($user);
        session(['name' => $user->name]); // Session'a isim ekle
        return redirect()->intended(route('login'));
    }


    public function logout()
    {
        Auth::logout();
        session()->flush(); // Tüm session’ı temizler
        return redirect()->route('home');
    }


}
