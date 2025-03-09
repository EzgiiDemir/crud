<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        // Filtreleme işlemleri burada yapılacak
        $query = Product::where('user_id', Auth::id()); // Kullanıcıya özel filtreleme

        // Eğer arama yapılmışsa, arama işlemi uygulanacak
        if ($request->has('search') && $request->search != '') {
            $query->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
        }

        // Ürünleri sıralayıp sayfalama işlemi yapıyoruz
        $products = $query->latest()->paginate(4);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) : RedirectResponse
    {
        try {
            // Ürünü kullanıcıyla ilişkilendirip kaydediyoruz
            Product::create(array_merge($request->validated(), [
                'user_id' => Auth::id(), // Kullanıcıyı ilişkilendiriyoruz
            ]));

            return redirect()->route('products.index')
                ->withSuccess('New product is added successfully.');
        } catch (\Exception $exception) {
            return redirect()->route('products.index')
                ->withErrors('New product is failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) : View
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) : View
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product) : RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->back()
                ->withSuccess('Product is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) : RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
                ->withSuccess('Product is deleted successfully.');
    }
}
