<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductRecommendationController extends Controller
{
public function index()
{
return view('investment-test');
}

public function recommend(Request $request)
{
$validated = $request->validate([
'budget' => 'required|numeric',
'term' => 'required|in:short,mid,long',
'risk' => 'required|in:low,medium,high',
'category' => 'nullable|string',
]);

$products = Product::query()
->when($validated['budget'], fn($q) => $q->where('price', '<=', $validated['budget']))
->when($validated['term'] == 'short', fn($q) => $q->where('risk_level', 'low'))
->when($validated['term'] == 'mid', fn($q) => $q->where('risk_level', 'medium'))
->when($validated['term'] == 'long', fn($q) => $q->where('risk_level', 'high'))
->when($validated['category'], fn($q) => $q->where('category', $validated['category']))
->get();

return response()->json($products);
}
}
