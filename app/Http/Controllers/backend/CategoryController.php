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
    	$categories = CategoryResource::collection(Category::all());

        $category_array = array();

        foreach ($categories as $key => $category) {
            if($category->parents == null)
            {
                array_push($category_array, $category);
            }
        }

        // return $category_array;

        return view('backend.categories.index', compact('category_array'));
    	
    }
}
