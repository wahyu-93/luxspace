<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
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
            $query = Product::query();
            return DataTables::of($query)
                ->editcolumn('aksi', function($item){
                    return '
                        <a href="'.route('dashboard.product.edit', $item->id).'" class="bg-gray-500 text-white px-3 py-1 rounded mr-3">
                            Edit
                        </a>

                        <form method="post" action="'. route('dashboard.product.destroy', $item->id) .'" class="inline-block">
                            '.csrf_field().' 
                            '.method_field('delete').'
                            
                            <button type="submit" class="bg-red-500 text-white rounded px-3 py-1 mr-3">Delete</button>

                        </form>
                    ';
                })
                ->editcolumn('price', function($item){
                    return number_format($item->price);
                })    
                ->rawColumns(['aksi'])
                ->make();
        }

        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        Product::create($data);

        return redirect()->route('dashboard.product.index');
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
    public function edit(Product $product)
    {
        return view('pages.dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}
