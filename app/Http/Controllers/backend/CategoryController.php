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
    // // testing
    // public function test()
    // {
    //     $categoryModel = new Category;

    //     $data = $categoryModel->recursiveChildId(5);

    //     array_unshift($data, 5);

    //     $boo = '';

    //     foreach($data as $dat)
    //     {
    //         $boo .= $dat;
    //     }

    //     return response()->json($boo);
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

        $categoryModel = new Category;
        $validation_childarray = $categoryModel->recursiveChildId($category->id);
        array_unshift($validation_childarray, $category->id);

        $validator = Validator::make($request->all(), [
            'parent' => 'required',
            'english.name' => 'required',
            'myanmar.name' => 'required',

        ]);

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

        $categories = Category::whereHas('category_infos', function ($query) use ($search){
                            $query->where('name','like', '%' .$search. '%')
                                    ->orwhere('description','like', '%' .$search. '%');
                            })->paginate(20);


        return view('backend.categories.index', compact('categories'));
    }
}
