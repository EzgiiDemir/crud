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
    public function rate(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
        ]);

        $product = Product::find($validated['product_id']);

        // Kullanıcının daha önce bu ürünü değerlendirmemiş olduğunu kontrol et
        $existingRating = $product->ratings()->where('user_id', auth()->id())->first();

        if ($existingRating) {
            // Eğer var ise, eski yorumu güncelle
            $existingRating->update(['rating' => $validated['rating']]);
        } else {
            // Eğer yoksa, yeni bir değerlendirme ekle
            $product->ratings()->create([
                'user_id' => auth()->id(),
                'rating' => $validated['rating'],
            ]);
        }

        // Ürünün ortalama puanını hesapla
        $averageRating = $product->ratings()->avg('rating');

        // Ortalama puanı güncelle
        $product->update(['average_rating' => round($averageRating, 1)]);

        return response()->json(['new_avg_rating' => $product->average_rating]);
    }
    public function like(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($validated['product_id']);

        // Kullanıcının daha önce bu ürünü beğenip beğenmediğini kontrol et
        $like = $product->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            // Eğer kullanıcı beğenmişse, beğenisini kaldır
            $like->delete();
            $likeCount = $product->likes()->count();
        } else {
            // Eğer beğenmemişse, beğeniyi ekle
            $product->likes()->create(['user_id' => auth()->id()]);
            $likeCount = $product->likes()->count();
        }

        return response()->json(['new_like_count' => $likeCount]);
    }
    public function comment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'text' => 'required|string|max:500',
        ]);

        $product = Product::find($validated['product_id']);

        $comment = $product->comments()->create([
            'user_id' => auth()->id(),
            'text' => $validated['text'],
        ]);

        // Yorum sayısını güncelle
        $commentCount = $product->comments()->count();

        return response()->json(['new_comment_count' => $commentCount]);
    }

}
