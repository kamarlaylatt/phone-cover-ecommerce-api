<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductListResourceCollection;
use App\Http\Resources\ProductDetailResource;
use App\Category;
use App\Product;

class ProductController extends BaseController
{
    public function getProductList(Request $request)
    {
        $category = Category::find($request->category_id);
        if($category)
        {
            return new ProductListResourceCollection($category->products()->paginate(20));
        }else{
            return $this->successResponse(null, 'There is no product list in this cateogory');
        }
    }

    public function getProductDetail(Request $request)
    {
        $product = Product::find($request->product_id);
        if($product)
        {
            $responseBody = new ProductDetailResource(Product::find($request->product_id));
        }else{
            $responseBody = null;
        }
        return $this->successResponse($responseBody, 'Success retrieve product detail');
    }
}
