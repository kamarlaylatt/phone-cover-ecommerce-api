<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Category;
class CategoryController extends Controller
{
    public function index()
    {
    	
    	
    }

    public function create()
    {
        $categories = CategoryResource::collection(Category::all());

        $category_array = array();

        foreach ($categories as $key => $category) {
            if($category->parents == null)
            {
                array_push($category_array, $category);
            }
        }

        // return $category_array;

        return view('backend.categories.create', compact('category_array'));
    }

    public function store(Request $request)
    {
        Category::Create([
            'name' => $request['name'],
            'parents' => $request['category'],
            'description' => $request['description'],
            'image' => $request['image'],
        ]);

        $data = [
            'success' => true,
        ];
        return response()->json($data);
    }
}
