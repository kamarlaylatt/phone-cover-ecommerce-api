<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Category;
use App\CategoryInfo;
use Validator;
use File;
use DB;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    // public function test()
    // {
    //     $categories = CategoryResource::collection(Category::where('id', 1)->get())->language_id(1);
        
    //     $category = Category::find(1);
    //     return response()->json($category->children);
    // }
    public function index()
    {
        $categories = Category::paginate(20);
    	return view('backend.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::find($id);
        $img_url = url(Storage::url('uploads/category_imgs/'.$category->image));
        return view('backend.categories.show', compact('category','img_url'));
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
            
            'parent' => 'required',
            'image' => 'required|unique:categories',
            'english.name' => 'required',
            'myanmar.name' => 'required',

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
            'parents' => $request['parent'],
            // 'image' => $request['image'],
        ]);

        CategoryInfo::Create([
            'category_id' => $category->id,
            'language_id' => $request['english.language_id'],
            'name' => $request['english.name'],
            'description' => $request['english.description'],
        ]);

        CategoryInfo::Create([
            'category_id' => $category->id,
            'language_id' => $request['myanmar.language_id'],
            'name' => $request['myanmar.name'],
            'description' => $request['myanmar.description'],
        ]);

        if($request->get('image'))
        {
                // $file = $request->file('image');
                // $filename = uniqid().'_'.$file->getClientOriginalName();
                // Storage::disk('public')->putFileAs('/uploads/category_imgs/', $file, $filename);
                $image = $request->get('image');
                $filename = uniqid().'_'.$request['english.name'].'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
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
            'parent' => 'required',
            'english.name' => 'required',
            'myanmar.name' => 'required',

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
        $category->parents = $request['parent'];

        $eng_category = $category->category_infos->where('language_id',1)->first();
        $myan_category = $category->category_infos->where('language_id',2)->first();

        $eng_category->name =  $request['english.name'];
        $eng_category->description = $request['english.description'];
        $eng_category->save();

        $myan_category->name =  $request['myanmar.name'];
        $myan_category->description = $request['myanmar.description'];
        $myan_category->save();
        
        // $category->image = $request['image'];
        $category->save();

        if($request->get('image'))
        {
            Storage::delete('public/uploads/category_imgs/'.$category->image); 
                       
            $image = $request['image'];
            $filename = uniqid().'_'.$request['english.name'].'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
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

    public function destroy($id)
    {
        $category = Category::find($id);

        if($category->children->count() != 0)
        {
            return redirect()->back()->with('error', 'Sorry, this Category has child, can\'t delete!');   
        }
        else{
            Storage::delete('public/uploads/category_imgs/'.$category->image);            
            $category->delete();
            return redirect()->back()->with('success', 'Successfully delete category'); 
        }        
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
