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
    public function index(Request $request): View
    {
        $query = Product::where('user_id', Auth::id());

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->get();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            Product::create(array_merge(
                $request->validated(),
                ['user_id' => Auth::id()]
            ));

            return redirect()->route('products.index')
                ->withSuccess('Product successfully added.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors('An error occurred while adding a product: ' . $e->getMessage());
        }
    }

    public function show(Product $product): View
    {
        $this->authorizeAccess($product);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $this->authorizeAccess($product);
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorizeAccess($product);

        try {
            $product->update($request->validated());
            return redirect()->back()->withSuccess('Product updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Update error: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeAccess($product);
        $product->delete();

        return redirect()->route('products.index')
            ->withSuccess('The product has been deleted.');
    }


    protected function authorizeAccess(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to access this product.');
        }
    }
}
