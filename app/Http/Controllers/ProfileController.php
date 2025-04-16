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
            'profile_picture' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ],
        ], [
         'profile_picture.required' => 'You need to select a profile picture.',
         'profile_picture.image' => 'The uploaded file must be an image.',
         'profile_picture.mimes' => 'Only jpeg, png, jpg and gif formats are supported.',
         'profile_picture.max' => 'Profile picture can be up to 2MB.',
        ]);

        $user = Auth::user();


        if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
            unlink(public_path($user->profile_picture));
        }

        $image = $request->file('profile_picture');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('profile_pictures'), $imageName);

        $user->profile_picture = 'profile_pictures/' . $imageName;
        $user->save();

        return redirect()->back()->with('success', 'Profile photo successfully updated!');
    }

    public function edit()
    {
        return view('products.profiledit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password verification does not match.',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('account')->with('success', 'Profile updated successfully.');
    }
}

