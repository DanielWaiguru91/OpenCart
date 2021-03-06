<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories(){
        $category = Category::with('product')->get();
        return CategoryResource::collection($category);
    }

    public function addCategory(Request $request){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return response([
            'message' => 'Category added'
        ]);
    }

    public function showCategory($id){
        $category = Category::where('id', $id)
            ->with('product')->first();

        if ($category) {
            return new CategoryResource($category);
        } else {
            return response([
                'message' => 'Category not found'
            ]);
        }
    }

    public function updateCategory($id, Request $request){
//        $request->validate([
//            'name' => 'required|string|max:255'
//        ]);

        $data = [
            'name' => $request->name
        ];

        $category = Category::where('id', $id)->with('product')->first();

        $category->update($data);

        return new CategoryResource($category);
    }

    public function deleteCategory($id) {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $category->delete();
            return response([
                'message' => 'Category deleted'
            ]);
        } else {
            return response([
                'error!' => 'Category not found'
            ]);
        }
    }
}
