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
        return view('products/login');  // Return the login form view (adjust the path as needed)
    }

    // Handle the login logic
    public function login(Request $request)
    {
        // Validate the login form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to log the user in using email and password
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            // If authentication is successful, redirect to the intended page
            return redirect()->intended(route('login'));  // Adjust this route as needed
        } else {
            // If authentication fails, return to login with an error message
            return redirect()->route('login.form')->withErrors(['login' => 'Invalid credentials.']);
        }
    }

    // Handle logout logic
    public function logout()
    {
        Auth::logout();  // Log the user out
        return redirect()->route('home');  // Redirect to login page after logout
    }
}
