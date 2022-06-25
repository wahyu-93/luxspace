<?php

namespace App\Http\Controllers;

use App\Http\Requests\galeryRequest;
use App\Models\Galery;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            $query = Galery::where('product_id', $product->id)->get();
            return DataTables::of($query)
                ->editcolumn('aksi', function($item){
                    return '
                        <form method="post" action="'. route('dashboard.galery.destroy', $item->id) .'" class="inline-block">
                            '.csrf_field().' 
                            '.method_field('delete').'
                            
                            <button type="submit" class="bg-red-500 text-white rounded px-3 py-1 mr-3">Delete</button>

                        </form>
                    ';
                })
                ->editcolumn('url', function($item){
                    return '<img src="'.Storage::url($item->url).'" style="max-width: 450px;"></img>';
                })
                ->editcolumn('is_featured', function($item){
                    return $item->is_featured ? 'Yes' : 'No';
                })
                ->rawColumns(['aksi', 'url'])
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
        $files = $request->file('files');
        
        if($request->hasFile('files')){
            foreach($files as $file){
                $path = $file->store('public/gallery/' .$product->id);
                
                Galery::create([
                    'product_id'   => $product->id,
                    'url'   => $path
                ]);
            };
        };

        return redirect()->route('dashboard.product.galery.index', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galery $galery)
    {
        $galery->delete();
        return redirect()->route('dashboard.product.galery.index', $galery->product_id);
    }
}
