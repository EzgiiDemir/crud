<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // EKLENDİ
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('products/register');  // Return a view for the registration form (adjust the path as needed)
    }

    // Handle the registration logic
    public function register(Request $request)
    {
        // Validate the registration form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:5',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the new user's information
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),  // Hash the password
        ]);

        // Optionally, log the user in after registration (using Laravel's Auth)
    auth()->login($user);


        // Redirect to a desired page after successful registration
        return redirect()->route('register');  // Adjust this route as needed
    }
}
