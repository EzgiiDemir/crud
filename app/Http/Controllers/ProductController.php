<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

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

            $product = Product::create($data);

            if ($request->has('category_ids')) {
                $categories = Category::find($request->category_ids);
                $product->categories()->attach($categories);
            }

            return redirect()->route('products.index')
                ->withSuccess('Product successfully added.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors('An error occurred while adding the product: ' . $e->getMessage());
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
    public function rateProduct(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Ratingi kaydet (örnek basit bir yapı)
        $product->ratings()->create([
            'rating' => $request->rating,
            'user_id' => auth()->id(),
        ]);

        // Yeni ortalamayı hesapla
        $newAverage = $product->ratings()->avg('rating');

        $product->average_rating = $newAverage;
        $product->save();

        return response()->json(['new_average_rating' => number_format($newAverage, 1)]);
    }



    public function increase($id): \Illuminate\Http\JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->like_count = ($product->like_count ?? 0) + 1;
        $product->save();

        return response()->json(['like_count' => $product->like_count]);
    }

    public function decrease($id): \Illuminate\Http\JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->like_count = max(($product->like_count ?? 0) - 1, 0); // Like 0'ın altına düşmesin
        $product->save();

        return response()->json(['like_count' => $product->like_count]);
    }

    public function comment(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:500',
        ]);

        $product = Product::find($validated['product_id']);

        // Add the comment
        $comment = $product->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        // Load user relationship (name, profile_picture)
        $comment->load('user');

        // Update the comment count
        $commentCount = $product->comments()->count();

        return response()->json([
            'new_comment_count' => $commentCount,
            'comment' => [
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'name' => $comment->user->name,
                    'profile_picture' => $comment->user->profile_picture ?? 'https://static.vecteezy.com/system/resources/previews/020/765/399/large_2x/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg',
                ],
            ]
        ]);
    }
    public function removeCategory($productId, $categoryId): RedirectResponse
    {
        $product = Product::findOrFail($productId);
        $category = Category::findOrFail($categoryId);

        $product->categories()->detach($categoryId);

        return redirect()->route('products.index')
            ->withSuccess('Category removed from product.');
    }


}
