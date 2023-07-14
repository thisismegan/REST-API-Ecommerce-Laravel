<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryName'  => 'required',
            'categoryImage' => 'required|image|mimes:jpeg,png,jpg,svg,webp,JPEG,PNG,JPG,SVG,WEBP',
        ]);

        $file = $request->file('categoryImage');

        $name = explode('.', $file->hashName())[0];
        $extension = strtolower($file->getClientOriginalExtension());
        $image = $name . "." . $extension;

        $file->storeAs('public/category', $image);


        $category = Category::create([
            'categoryName'  => $request->categoryName,
            'categoryImage' => $image,
        ]);

        return $this->success($category, 'Successfully');
    }


    public function show($id)
    {
        $category = Category::find($id);

        return $this->success($category, 'Data Category');
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'categoryName' => 'required'
        ]);

        $category = Category::find($id);

        if ($request->hasFile('categoryImage')) {

            Storage::delete('public/category/' . basename($category->categoryImage));


            $file = $request->file('categoryImage');

            $name = explode('.', $file->hashName())[0];
            $extension = strtolower($file->getClientOriginalExtension());
            $image = $name . "." . $extension;


            $file->storeAs('public/category', $image);

            $category->update([
                'categoryName' => $request->categoryName,
                'categoryImage' => $image
            ]);
        } else {
            $category->update([
                'categoryName' => $request->categoryName
            ]);
        }

        return $this->success($category, 'Updated Successfully');
    }
}
