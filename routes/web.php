<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountController;

Route::get('/create', function () {
    return view('products.create');
})->name('create');


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::resource('products', ProductController::class);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

use App\Http\Controllers\ProfileController;


Route::get('/profile/picture/change', [ProfileController::class, 'changePicture'])->name('profile.picture.change');


Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/account', [AccountController::class, 'showAccount'])->name('account');


Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');