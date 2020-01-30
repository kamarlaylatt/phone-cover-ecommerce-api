<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Category;
class CategoryController extends Controller
{
    public function getTree()
    {
        $categories = CategoryResource::collection(Category::all());

        $children_array = array();       

        foreach ($categories as $key => $category) {
            if($category->parents == 0)
            {
                array_push($children_array, $category);
            }
        }

        $category_array = [
            [
                'id' => '0',
                'name' => 'root',
                'icon' => 'fa fa-folder',
                'parent' => '',
                'children'=> $children_array,
                'description'=> '',
                'opened' => true,
                'image'=> '',
            ],
            
        ];

        return $category_array;
    }

    public function index()
    {
        $category_array = $this->getTree();
    	return view('backend.categories.index', compact('category_array'));
    }

    public function create()
    {
        $category_array = $this->getTree();

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
