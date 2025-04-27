<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
class MarketController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['user',  'comments.user', 'likes.user'])
                    ->withCount(['comments', 'likes'])
                    ->active();
                    Product::query()->update(['is_active' => true]);

        // Arama filtresi
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        // Kategori filtresi
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Sıralama
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('likes_count', 'desc');
                break;
            case 'most_commented':
                $query->orderBy('comments_count', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        return view('products.market', compact('products'));
    }

    // Ürün detay sayfası
    public function show(Product $product): View
    {
        $product->load(['user', 'comments.user', 'likes.user']);
        return view('market.show', compact('product'));
    }

    // Yorum ekleme
    public function addComment(Request $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $comment = $product->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Yorumunuz eklendi.');
    }

    // Beğeni ekleme/kaldırma
    public function toggleLike(Product $product): \Illuminate\Http\RedirectResponse
    {
        $like = $product->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            $message = 'Beğeni kaldırıldı.';
        } else {
            $product->likes()->create(['user_id' => Auth::id()]);
            $message = 'Ürün beğenildi.';
        }

        return back()->with('success', $message);
    }

    // Favorilere ekleme
    public function toggleFavorite(Product $product): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
            $message = 'Favorilerden kaldırıldı.';
        } else {
            $user->favorites()->attach($product->id);
            $message = 'Favorilere eklendi.';
        }

        return back()->with('success', $message);
    }

}
