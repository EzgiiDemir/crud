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
        $trashedProducts = Product::onlyTrashed()
        ->where('user_id', Auth::id())
        ->latest()
        ->get();
        return view('products.index', compact('products', 'trashedProducts'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($data);

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
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($data);

            return redirect('products')->withSuccess('Product updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Update error: ' . $e->getMessage());
        }
    }
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeAccess($product);
        $product->delete(); // artık soft delete

        return redirect()->route('products.index')
            ->withSuccess('The product has been deleted.');
    }

    protected function authorizeAccess(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to access this product.');
        }
    }
    public function restore($id): RedirectResponse
{
    $product = Product::onlyTrashed()->findOrFail($id);
    $this->authorizeAccess($product);
    $product->restore();

    return redirect()->route('products.index')
        ->withSuccess('Product has been restored.');
}

}
