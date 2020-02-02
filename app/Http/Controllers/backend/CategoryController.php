<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Category;
use Validator;
class CategoryController extends Controller
{

    public function index()
    {
        // $categories = CategoryResource::collection(Category::all());
        // $category = Category::find(5);
        // return $category->parent->parent;
        $categories = Category::paginate(20);
    	return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        $categoryModel = new Category;
        $category_array = $categoryModel->getChildrenTree();
        // return $category_array;

        return view('backend.categories.create', compact('category_array'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'image' => 'required|unique:categories',

        ]);

        if($validator->fails()){
            
            $errors_array = array(); 

            $errors = $validator->errors();

            foreach ($errors->all() as $error) {
                $error_array = explode(" ", $error);
                $data = [
                    "fieldCode" => $error_array[1],
                    "errorMessage" => $error,
                ];

                array_push($errors_array, $data);
            }

            return response()->json([
                'success' => false,
                'validation' => false,
                'responseMessage' => 'Multiple Error',
                'errors' => $errors_array,
            ]);  
            
        }

        Category::Create([
            'name' => $request['name'],
            'parents' => $request['category'],
            'description' => $request['description'],
            'image' => $request['image'],
        ]);

        $data = [
            'success' => true,
            'validation' => true,
        ];
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $categories = Category::where('name','like', '%'.$search.'%')
                        ->orwhere('description', 'like', '%'.$search.'%')
                        ->paginate(20);

        return view('backend.categories.index', compact('categories'));
    }
}
