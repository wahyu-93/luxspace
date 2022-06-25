<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
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
                        <a href="'.route('dashboard.product.edit', $item->id).'" class="bg-gray-500 text-white px-3 py-1 rounded mr-3">
                            Show
                        </a>
                    
                        <a href="'.route('dashboard.product.edit', $item->id).'" class="bg-gray-500 text-white px-3 py-1 rounded mr-3">
                            Edit
                        </a>
                    ';
                })
                ->editcolumn('total_price', function($item){
                    return number_format($item->price);
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
