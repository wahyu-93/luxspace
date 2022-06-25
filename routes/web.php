<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
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

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/details/{slug}', [FrontController::class, 'detail'])->name('details');
Route::get('/cart', [FrontController::class, 'cart'])->name('cart');\
Route::get('/checkout/succes', [FrontController::class, 'success'])->name('checkout-success');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->name('dashboard.')->prefix('dashboard')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::middleware(['admin'])->group(function(){
        Route::resource('product', ProductController::class);
        Route::resource('product.galery', GalleryController::class)->shallow()->except(['edit', 'update', 'show']);
        Route::resource('transaction', TransactionController::class)->shallow()->except(['create', 'destroy', 'store']);
    });
});
