<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    public function index()
    {
    	$categories = Category::all();
    	$tree_array = array();

    	foreach ($categories as $key => $category) {
    		$obj = [
    			'name' => $category->name,
    			'image_url' => $category->image,
    		];
    		array_push($tree_array, $obj);
    	}

    	return $tree_array;
    }
}
