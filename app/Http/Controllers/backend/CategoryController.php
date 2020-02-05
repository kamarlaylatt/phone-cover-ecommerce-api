<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Category;
use Validator;
use File;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{

    public function index()
    {
        // $language_id =1;
        $categories = CategoryResource::collection(Category::all(), $language_id=1);
        return response()->json($categories);
        // $category = Category::find(5);
        // return $category->parent->parent;
        // $categories = Category::paginate(20);
    	// return view('backend.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::find($id);
        return view('backend.categories.show', compact('category'));
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

        $category = Category::Create([
            'name' => $request['name'],
            'parents' => $request['category'],
            'description' => $request['description'],
            // 'image' => $request['image'],
        ]);

        if($request->get('image'))
        {
                // $file = $request->file('image');
                // $filename = uniqid().'_'.$file->getClientOriginalName();
                // Storage::disk('public')->putFileAs('/uploads/category_imgs/', $file, $filename);
                $image = $request->get('image');
                $filename = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $file = \Image::make($request['image']);
                // Storage::disk('public')->putFileAs('/uploads/category_imgs/', $file, $filename);
                Storage::put('public/uploads/category_imgs/' . $filename, $file->encode());
                $category->image = $filename;
                $category->save();
        }

        $data = [
            'success' => true,
            'validation' => true,
        ];
        return response()->json($data);
    }

    public function edit($id)
    {
        $categoryModel = new Category;
        $category_array = $categoryModel->getChildrenTree();
        $category = Category::find($id);
        $img_url = url(Storage::url('uploads/category_imgs/'.$category->image));
        return view('backend.categories.edit', compact('category','category_array','img_url'));
    }

    public function update(Request $request)
    {
        $category = Category::find($request['id']);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',

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
        
        $category->name =  $request['name'];
        $category->description = $request['description'];
        $category->parents = $request['category'];
        // $category->image = $request['image'];
        $category->save();

        if($request->get('image'))
        {
            $image = $request['image'];
            $filename = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $file = \Image::make($request['image']);
            Storage::put('public/uploads/category_imgs/' . $filename, $file->encode());
            $category->image = $filename;
            $category->save();    
        }

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
