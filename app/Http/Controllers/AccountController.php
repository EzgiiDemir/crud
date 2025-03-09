<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function showAccount()
    {

        $products = Product::where('user_id', Auth::id())->latest()->paginate(5);

        return view('products.account', compact('products'));

    }
}
