<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('pages.frontend.index');
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
