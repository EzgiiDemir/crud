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

    // Handle the login logic
    public function login(Request $request)
    {
        // Login form verilerini doğrula
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Eğer doğrulama başarısız olursa, hata mesajlarıyla geri dön
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Email ve şifre ile kullanıcıyı giriş yaptırmayı dene
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            // Eğer kimlik doğrulama başarılı olursa, kullanıcının bilgisini al
            $user = Auth::user();

            // Kullanıcının adını session'a kaydet
            session(['name' => $user->name]);

            // Başarılı girişten sonra hedef sayfaya yönlendir
            return redirect()->intended(route('login'));  // Gerekirse rotayı güncelle
        } else {
            // Kimlik doğrulama başarısız olursa, login sayfasına hata mesajıyla geri dön
            return redirect()->route('login.form')->withErrors(['login' => 'Invalid credentials.']);
        }
    }

    // Handle logout logic
    public function logout()
    {
        Auth::logout();  // Kullanıcıyı oturumdan çıkart
        return redirect()->route('home');  // Oturumdan çıktıktan sonra ana sayfaya yönlendir
    }
}
