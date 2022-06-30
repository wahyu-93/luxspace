<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

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

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->all();

        // get data carts
        $carts = Cart::with(['product'])->where('user_id', auth()->user()->id)->get();

        // add to transaction data
        $data['user_id']     = auth()->user()->id;
        $data['total_price'] = $carts->sum('product.price');

        // create transaction
        $transaction = Transaksi::create($data);

        // create transaction item
        foreach($carts as $cart){
            TransaksiItem::create([
                'transaksi_id'  => $transaction->id,
                'user_id'       => auth()->user()->id,
                'product_id'    => $cart->product_id
            ]);
        };
        
        // delete cart after transaction
        Cart::where('user_id', auth()->user()->id)->delete();

        // konfigurasi
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = Config('services.midtrans.isProduction');
        Config::$isSanitized = Config('services.midtrans.isSanitized');
        Config::$is3ds = Config('services.midtrans.is3ds');
        
        //  setup variabel midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id'  => 'LUX-' . $transaction->id,
                'gross_amount' => (int) $transaction->total_price
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
            ],
            'enabled_payments' => ['gopay', 'bank_transfer'],
            'vtweb' => []
        ];

        // payment process
        try {
            // get snap url 
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
            // save url ke table transaksi
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // redirect to snap payment url 

            return redirect($paymentUrl);

        } catch (Exception $e) {
            dd($e->getMessage());
            $e->getMessage();
        };
    }

    public function success()
    {
        return view('pages.frontend.success');
    }
}
