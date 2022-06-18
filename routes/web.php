<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('admin')->group(function(){
    Route::get('/', [FrontController::class, 'index'])->name('index');
    Route::get('/details/{slug}', [FrontController::class, 'detail'])->name('details');
    Route::get('/cart', [FrontController::class, 'cart'])->name('cart');\
    Route::get('/checkout/succes', [FrontController::class, 'success'])->name('checkout-success');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
