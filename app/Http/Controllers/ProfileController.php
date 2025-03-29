<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function changePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Eski resmi sil (Eğer resim varsa ve public dizindeyse)
        if ($user->profile_picture) {
            $oldImagePath = public_path($user->profile_picture);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Yeni resmi kaydet
        $image = $request->file('profile_picture');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('profile_pictures'), $imageName);

        // Kullanıcı modelini güncelle
        $user->profile_picture = 'profile_pictures/' . $imageName;
        $user->save();

        return redirect()->back()->with('success', 'Profile picture updated successfully!');
    }

    public function edit()
    {
        return view('products.profiledit');
    }
    public function update(Request $request)
    {
        // Doğrulama
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Kullanıcıyı al
        $user = Auth::user();

        // Profil bilgilerini güncelle
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Şifre güncellenmişse, yeni şifreyi kaydet
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Veritabanına kaydet
        $user->save();

        // Başarılı bir şekilde güncellendikten sonra yönlendirme
        return redirect()->route('account')->with('success', 'Profile updated successfully.');
    }
}
