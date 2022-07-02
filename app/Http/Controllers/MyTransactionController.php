<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MyTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // jalankkan jika requestnya ajak
        if(request()->ajax()){
            $query = Transaksi::with(['user'])->where('user_id', auth()->user()->id);
            return DataTables::of($query)
                ->editcolumn('aksi', function($item){
                    return '
                        <a href="'.route('dashboard.my-transaction.show', $item->id).'" class="bg-blue-500 text-white px-3 py-1 rounded mr-3">
                            Show
                        </a>
                    ';
                })
                ->editcolumn('total_price', function($item){
                    return number_format($item->total_price);
                })    
                ->rawColumns(['aksi'])
                ->make();
        }
    
        return view('pages.dashboard.transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $myTransaction)
    {
        if(request()->ajax()){
            $query = TransaksiItem::with(['product'])->where('transaksi_id', $myTransaction->id)->get();
            return DataTables::of($query)
                ->editcolumn('product.price', function($item){
                    return number_format($item->product->price);
                })    
                ->rawColumns(['aksi'])
                ->make();
        }

        return view('pages.dashboard.transaction.show', [
            'transaction'   => $myTransaction
        ]);
    }
}
