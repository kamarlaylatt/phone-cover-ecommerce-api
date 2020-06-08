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
        $categories = Category::orderBy('id', 'asc')->paginate(10);

    	return view('backend.categories.index', compact('categories'));
    }

    public function tree()
    {
        $categoryModel = new Category;
        $category_array = $categoryModel->getChildrenTree();
    	return view('backend.categories.tree', compact('category_array'));
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

        $rules = [
            'parent' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
            'english_name' => 'required',
            'myanmar_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

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
            'language_id' => $request['english_language_id'],
            'name' => $request['english_name'],
            'description' => $request['english_description'],
        ]);

        CategoryInfo::Create([
            'category_id' => $category->id,
            'language_id' => $request['myanmar_language_id'],
            'name' => $request['myanmar_name'],
            'description' => $request['myanmar_description'],
        ]);

        if($request->file('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/category_imgs/', $file, $filename);
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

        $categoryModel = new Category;
        $validation_childarray = $categoryModel->recursiveChildId($category->id);
        array_unshift($validation_childarray, $category->id);

        if($request->file('image'))
        {
            $rules = [
                'parent' => 'required',
                'image' => 'image',
                'english_name' => 'required',
                'myanmar_name' => 'required',
            ];
        }
        else{
            $rules = [
                'parent' => 'required',
                'english_name' => 'required',
                'myanmar_name' => 'required',
            ];
        }
            
        $validator = Validator::make($request->all(), $rules);

        $errors_array = array(); 

        if($validator->fails()){        

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

        foreach($validation_childarray as $validation)
        {
            if($validation == $request['parent'])
            {
                $data = [
                    "fieldCode" => 'parent repeat',
                    "errorMessage" => 'Can\'nt use that parent',
                ];
                array_push($errors_array, $data);
                return response()->json([
                    'success' => false,
                    'validation' => false,
                    'responseMessage' => 'Multiple Error',
                    'errors' => $errors_array,
                ]);
                break;
            }
            
        }


        $category->parents = $request['parent'];

        $eng_category = $category->category_infos->where('language_id',1)->first();
        $myan_category = $category->category_infos->where('language_id',2)->first();

        $eng_category->name =  $request['english_name'];
        $eng_category->description = $request['english_description'];
        $eng_category->save();

        $myan_category->name =  $request['myanmar_name'];
        $myan_category->description = $request['myanmar_description'];
        $myan_category->save();
        
        // $category->image = $request['image'];
        $category->save();

        if($request->file('image'))
        {
            Storage::delete('public/uploads/category_imgs/'.$category->image); 
                       
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/category_imgs/', $file, $filename);
            $category->image = $filename;
            $category->save();    
        }

        $data = [
            'success' => true,
            'validation' => true,
        ];
        
        return response()->json($data);
    }

    public function destroy(Request $request,$id)
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

        $categoryModel = new Category;
        $category_array = $categoryModel->getChildrenTree();

        $categories = Category::whereHas('category_infos', function ($query) use ($search){
                            $query->where('name','like', '%' .$search. '%')
                                    ->orwhere('description','like', '%' .$search. '%');
                            })->orderBy('id', 'asc')->paginate(20);


        return view('backend.categories.index', compact('categories','category_array'));
    }
}
