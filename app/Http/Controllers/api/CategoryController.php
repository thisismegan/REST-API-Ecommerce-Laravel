<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

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
            'categoryName' => 'required'
        ]);


        $category = Category::create([
            'categoryName' => $request->categoryName
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

        $category->update([
            'categoryName' => $request->categoryName
        ]);

        return $this->success($category, 'Updated Successfully');
    }
}
