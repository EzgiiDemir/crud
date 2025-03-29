<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController; // SettingsController Eklenmeli

// AUTHENTICATED ROUTES (Kullanıcı Giriş Yapmışsa)
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-picture', [ProfileController::class, 'changePicture'])->name('profile.changePicture');

    // Account Route
    Route::get('/account', [AccountController::class, 'showAccount'])->name('account');

    // Settings Route
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
});

// GUEST ROUTES (Giriş Yapmadan Erişilebilir)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

// Product Routes
Route::resource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Static Views
Route::get('/create', function () {
    return view('products.create');
})->name('create');

Route::get('/profile/picture/change', [ProfileController::class, 'changePicture'])->name('profile.picture.change');
Route::get('/profile/change-picture', [ProfileController::class, 'showChangePictureForm'])->name('profile.change-picture');
Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
