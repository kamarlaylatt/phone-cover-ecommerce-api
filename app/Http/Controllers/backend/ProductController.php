<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Http\Requests\backend\StoreProduct;

class ProductController extends Controller
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

    public function store(StoreProduct $request)
    {

    }
}
