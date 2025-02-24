<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/create', function () {
    return view('products.create');
})->name('create');


Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
