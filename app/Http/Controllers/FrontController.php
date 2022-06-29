<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

    public function cart()
    {
        return view('pages.frontend.cart');
    }

    public function success()
    {
        return view('pages.frontend.success');
    }
}
