<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //request ajax()
        if(request()->ajax()){
            $query = User::query();
            return DataTables::of($query)
                ->editcolumn('aksi', function($item){
                    return '
                        <a href="'.route('dashboard.user.edit', $item->id).'" class="bg-blue-500 text-white px-3 py-1 rounded mr-3">
                            Edit
                        </a>

                        <form method="post" class="inline-block" action="'.route('dashboard.user.destroy', $item->id).'">
                            '.method_field('delete'). csrf_field().'
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded mr-3">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make();
        };

        return view('pages.dashboard.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('pages.dashboard.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();

        $user->update($data);

        return redirect()->route('dashboard.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('dashboard.user.index');
    }
}
