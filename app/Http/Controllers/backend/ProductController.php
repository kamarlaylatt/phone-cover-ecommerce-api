<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Http\Requests\backend\StoreProduct;
use App\Http\Controllers\backend\BaseController as BaseController;

class ProductController extends BaseController
{
    public function index()
    {
    	return view('backend.products.index');
    }

    public function create()
    {
        $categoryModel = new Category;
        $category_array = $categoryModel->getChildrenTree();

        return view('backend.products.create', compact('category_array'));
    }

    public function store(Request $request)
    {
        // $rules = [
        //     'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
        //     'category_array' => 'required',
        //     'code_number' => 'required',
        //     'price' => 'required|numeric',
        //     'quantity' => 'required|numeric',
        //     'minimum_order' => 'required|numeric',
        //     'maximum_order' => 'required|numeric',
        //     'recommand' => 'required',
        //     'english_name' => 'required|string',
        //     'english_description' => 'required|string',
        //     'myanmar_name' => 'required|string',
        //     'myanmar_description' => 'required|string',
        // ];

        // $validation = $this->jsonValidate($request->all(), $rules);

        // if($validation['success'] == false)
        // {
        //     return $validation;
        // }

        $productModel = new Product;
        $product_store = $productModel->storeProduct($request->all());

        if($product_store['success'] == true)
        {
            return response()->json(['validation' => true]);
        }

    }
}
