<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        // mengecek user sudah login atau belum 
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'          => 'required|max:255|unique:products',
            'description'   => 'required',
            'price'         => 'required|integer'
        ];

        if($this->method() != 'POST'){
            $rules['name'] = 'required|max:255|unique:products,name,' . $this->route('product')->id;
        };

        return $rules;
        
    }
}
