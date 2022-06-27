<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
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
            $query = Transaksi::query();
            return DataTables::of($query)
                ->editcolumn('aksi', function($item){
                    return '
                        <a href="'.route('dashboard.transaction.show', $item->id).'" class="bg-blue-500 text-white px-3 py-1 rounded mr-3">
                            Show
                        </a>
                    
                        <a href="'.route('dashboard.transaction.edit', $item->id).'" class="bg-gray-500 text-white px-3 py-1 rounded mr-3">
                            Edit
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
    public function show(Transaksi $transaction)
    {
        if(request()->ajax()){
            $query = TransaksiItem::with(['product'])->where('transaksi_id', $transaction->id)->get();
            return DataTables::of($query)
                ->editcolumn('product.price', function($item){
                    return number_format($item->product->price);
                })    
                ->rawColumns(['aksi'])
                ->make();
        }

        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaction)
    {
        return view('pages.dashboard.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaksi $transaction)
    {
        $data = $request->all();

        $transaction->update($data);

        return redirect()->route('dashboard.transaction.index');
    }
}
