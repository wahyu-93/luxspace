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
        return view('pages.frontend.detail');
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
