<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MarketController;

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-picture', [ProfileController::class, 'changePicture'])->name('profile.changePicture');
    // Account Route
    Route::get('/account', [AccountController::class, 'showAccount'])->name('account');

    // Settings Route
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
});


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

// Product Routes
Route::resource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'index'])->name('products.store');


// Static Views
Route::get('/create', function () {
    return view('products.create');
})->name('create');
Route::get('/fee_calculator', function () {
    return view('products.fee_calculator');
})->name('fee_calculator');
Route::get('/payment', function () {
    return view('products.payment');
})->name('payment');
Route::get('/profile/picture/change', [ProfileController::class, 'changePicture'])->name('profile.picture.change');
Route::get('/profile/change-picture', [ProfileController::class, 'showChangePictureForm'])->name('profile.change-picture');
Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
Route::put('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
Route::get('/market', [ProductController::class, 'market']);
Route::get('/market', function () {
    return view('products.market');
})->name('market');

Route::controller(MarketController::class)->group(function () {
    Route::get('/market', 'index')->name('products.market');
    Route::get('/market/{product}', 'show')->name('market.show');
    Route::post('/market/{product}/comment', 'addComment')->name('market.comment');
    Route::post('/market/{product}/like', 'toggleLike')->name('market.like');
    Route::post('/market/{product}/favorite', 'toggleFavorite')->name('market.favorite');
});
Route::resource('products', ProductController::class);
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/products/rate', [ProductController::class, 'rate'])->name('products.rate');
Route::post('/products/like', [ProductController::class, 'like'])->name('products.like');
Route::post('/products/comment', [ProductController::class, 'comment'])->name('products.comment');
Route::get('/products/comment', [ProductController::class, 'comment'])->name('products.comment');
Route::get('/api/countries',       [FeeCalculatorController::class, 'countries']);
Route::get('/api/terms',           [FeeCalculatorController::class, 'terms']);
// ...
Route::post('/api/calculate',      [FeeCalculatorController::class, 'calculate']);
use App\Http\Controllers\ProductRecommendationController;
Route::get('/investment-test', [ProductRecommendationController::class, 'index']);
Route::post('/api/recommend-products', [ProductRecommendationController::class, 'recommend']);
Route::post('/rate-product', [ProductController::class, 'rateProduct']);
Route::post('/product/{id}/increase', [ProductController::class, 'increase']);
Route::post('/product/{id}/decrease', [ProductController::class, 'decrease']);
Route::get('/product/{id}/increase', [ProductController::class, 'increase']);
Route::get('/product/{id}/decrease', [ProductController::class, 'decrease']);
Route::get('/rate-product', [ProductController::class, 'rateProduct']);
Route::post('/product/{id}/comment', [ProductController::class, 'postComment']);
