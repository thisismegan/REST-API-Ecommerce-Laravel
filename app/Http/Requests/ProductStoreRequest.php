<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id'   => 'required|numeric',
            'productName'   => 'required|max:70|unique:products',
            'description'   => 'required',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'weight'        => 'required|numeric',
            'image'         => 'required|array',
            'image.*'       => 'required|image|mimes:jpeg,png,jpg,svg,webp,JPEG,PNG,JPG,SVG,WEBP',
        ];
    }
}
