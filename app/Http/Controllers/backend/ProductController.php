<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Http\Requests\backend\StoreProduct;
use App\Http\Controllers\backend\BaseController as BaseController;
use Storage;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::paginate(10);
    	return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $categoryModel = new Category;
        $category_array = $categoryModel->getChildrenTree();

        return view('backend.products.create', compact('category_array'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        $img_url = url(Storage::url('uploads/product_imgs/thumbnail/'.$product->image));
        return view('backend.products.show', compact('product','img_url'));
    }

    public function store(Request $request)
    {
        $rules = [
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
            'category_array' => 'required',
            'code_number' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'minimum_order' => 'required|numeric',
            'maximum_order' => 'required|numeric',
            'english_name' => 'required|string',
            'english_description' => 'required|string',
            'myanmar_name' => 'required|string',
            'myanmar_description' => 'required|string',
        ];

        $validation = $this->jsonValidate($request->all(), $rules);

        if($validation['success'] == false)
        {
            return $validation;
        }

        $productModel = new Product;
        $product_store = $productModel->storeProduct($request->all());

        $product = Product::find($product_store['product_id']);

        if($request->hasFile('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/product_imgs/thumbnail/', $file, $filename);
                $product->image = $filename;
                $product->save();
        }

        if($product_store['success'] == true)
        {
            return response()->json(['validation' => true]);
        }

    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categoryModel = new Category;
        $category_array = $categoryModel->getChildrenTree();
        $thumbnail_url = url(Storage::url('uploads/product_imgs/thumbnail/'.$product->image));

        $images = array();

        foreach($product->images as $image)
        {
            $image_path = (string) \Image::make(storage_path('app/public/uploads/product_imgs/images/'.$image->image))->encode('data-url');
            $obj = [
                'id' => $image->id,
                'name' => $image->image,
                'path' => $image_path,
                'highlight' => 0,
                'default' => 0,
                'update_status' => 0,
                'create_status' => 0,
            ];
            array_push($images, $obj);
        }

        return view('backend.products.edit', compact('category_array','product','thumbnail_url','images'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            // 'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
            'category_array' => 'required',
            'code_number' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'minimum_order' => 'required|numeric',
            'maximum_order' => 'required|numeric',
            'english_name' => 'required|string',
            'english_description' => 'required|string',
            'myanmar_name' => 'required|string',
            'myanmar_description' => 'required|string',
        ];

        $validation = $this->jsonValidate($request->all(), $rules);

        if($validation['success'] == false)
        {
            return $validation;
        }

        $productModel = new Product;
        $product_store = $productModel->updateProduct($request->all(), $id);

        
        $product = Product::find($id);

        if($request->hasFile('image'))
        {
            Storage::delete('public/uploads/product_imgs/thumbnail/'.$product->image); 
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/product_imgs/thumbnail/', $file, $filename);
            $product->image = $filename;
            $product->save();
        }

        if($product_store['success'] == true)
        {
            return response()->json(['validation' => true]);
        }

    }

    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete('public/uploads/product_imgs/thumbnail/'.$product->image);
        foreach($product->images as $p_image)
        {
            Storage::delete('public/uploads/product_imgs/images/'.$p_image->image);
        }

        $detach_array = array();
        foreach($product->categories as $cat)
        {
            array_push($detach_array, $cat->id);
        }
        $category = Category::find($detach_array);
        $product->categories()->detach($category);

        $product->delete();
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $products = Product::where('code_number', 'like', '%'.$search.'%')
                            ->orWhere('price', 'like', '%'.$search.'%')
                            ->orWhereHas('infos',function ($query) use ($search){
                                $query->where('name','like', '%'.$search.'%')
                                    ->orWhere('description', 'like', '%'.$search.'%');
                            })
                            ->orderBy('id','asc')->paginate(10);

        return view('backend.products.index', compact('products'));
        
    }
}
