<?php

namespace App\Http\Controllers;

use App\Http\Requests\galeryRequest;
use App\Models\Galery;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        // jalankkan jika requestnya ajak
        if(request()->ajax()){
            $query = Galery::query();
            return DataTables::of($query)
                ->editcolumn('aksi', function($item){
                    return '
                        <form method="post" action="'. route('dashboard.product.destroy', $item->id) .'" class="inline-block">
                            '.csrf_field().' 
                            '.method_field('delete').'
                            
                            <button type="submit" class="bg-red-500 text-white rounded px-3 py-1 mr-3">Delete</button>

                        </form>
                    ';
                })
                ->editcolumn('url', function($item){
                    return 'Foto';
                })
                ->editcolumn('is_featured', function($item){
                    return $item->is_featured ? 'Yes' : 'No';
                })
                ->rawColumns(['aksi'])
                ->make();
        }

        return view('pages.dashboard.galery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('pages.dashboard.galery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(galeryRequest $request, Product $product)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
