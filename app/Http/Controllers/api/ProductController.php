<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Validation\Rule;
use App\Traits\HttpResponses;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    use HttpResponses;

    public function index()
    {
        $products = Product::with('image')->filter(request(['search']))->category(request(['category']))->get();

        return $this->success($products, 'Data Products');
    }


    public function store(ProductStoreRequest $request)
    {

        $request->validated($request->all());


        // Input data to table products
        $product = Product::create([
            'category_id'  => $request->category_id,
            'productName'  => $request->productName,
            'description'  => $request->description,
            'quantity'     => $request->quantity,
            'price'        => $request->price,
            'weight'       => $request->weight,
            'status'       => 'enable'
        ]);


        // Input data to table images 
        $files = $request->file('image');

        foreach ($files as $file) {
            $name = explode('.', $file->hashName())[0];
            $extension = strtolower($file->getClientOriginalExtension());
            $image = $name . "." . $extension;

            $file->storeAs('public/product', $image);

            Image::create([
                'product_id'   => $product->id,
                'imageName'    => $image
            ]);
        }

        return $this->success($product, 'Successfully!');
    }


    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        return $product ? $this->success(new ProductResource($product), 'Detail Product') : $this->failed('', 'Record Not Found', 404);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id'   => 'required|numeric',
            'productName'   => 'required|max:70',
            'description'   => 'required',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'weight'        => 'required|numeric',
            'status'        => [
                'required', Rule::in(['enable', 'disable']),
            ],
            'image'         => 'nullable|array',
            'image.*'       => 'image|mimes:jpeg,png,jpg,svg,webp,JPEG,PNG,JPG,SVG,WEBP',

        ]);

        $product = Product::where('id', $id)->first();


        $product->update([
            'category_id'  => $request->category_id,
            'productName'  => $request->productName,
            'description'  => $request->description,
            'quantity'     => $request->quantity,
            'price'        => $request->price,
            'weight'       => $request->weight,
            'status'       => $request->status,
        ]);

        if ($request->hasFile('image')) {
            $files = $request->file('image');

            foreach ($files as $file) {
                $name = explode('.', $file->hashName())[0];
                $extension = strtolower($file->getClientOriginalExtension());
                $image = $name . "." . $extension;

                $file->storeAs('public/product', $image);

                Image::create([
                    'product_id'   => $product->id,
                    'imageName'    => $image
                ]);
            }
        }

        return $this->success($product, 'Successfully Updated Product');
    }

    public function deleteImage(Request $request)
    {
        $image = Image::find($request->id);

        Storage::delete('public/product/' . basename($image->imageName));

        $image->delete();

        return $this->success('', 'Sucesssfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        $images = Image::where('product_id', $product->id)->get();

        foreach ($images as $image) {
            Storage::delete('public/product/' . basename($image->imageName));
        }

        //delete image product
        Image::where('product_id', $id)->delete();

        //delete data product
        $product->delete();

        return $this->success('', 'successfully!');
    }
}
