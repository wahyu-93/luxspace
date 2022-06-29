<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::with(['galeries'])->latest()->take(10)->get();
        
        return view('pages.frontend.index', compact('products'));
    }

    public function detail($slug)
    {
        $product = Product::with(['galeries'])->where('slug', $slug)->firstOrFail();
        $recomendations = Product::with(['galeries'])->inRandomOrder()->limit(4)->get();

        return view('pages.frontend.detail', compact('product', 'recomendations'));
    }

    public function cartAdd(Request $request, $id)
    {
        Cart::create([
            'user_id'    => Auth::user()->id,
            'product_id' => $id
        ]);

        return redirect()->route('cart');
    }

    public function cartDelete($id)
    {
        $item = Cart::findOrFail($id);

        $item->delete();

        return redirect()->route('cart');
    }

    public function cart()
    {
        // nested relasi cart berelsai dengan product tapi kita perlu galeri juga maka kita bisa nested relas
        // cart::with(['product.galeries])
        $carts = Cart::with(['product.galeries'])->where('user_id', Auth::user()->id)->get();

        return view('pages.frontend.cart', compact('carts'));
    }

    public function success()
    {
        return view('pages.frontend.success');
    }
}
