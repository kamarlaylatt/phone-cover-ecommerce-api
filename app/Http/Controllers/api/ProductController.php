<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductDetailResource;
use App\Category;
use App\Product;

class ProductController extends BaseController
{
    public function getProductList(Request $request)
    {
        $category = Category::find($request->category_id);
        $products = $category->products;
        $responseBody = [
            'productList' => ProductListResource::collection($products),
        ];

        return $this->successResponse($responseBody, 'Success retrieve product list');
    }

    public function getProductDetail(Request $request)
    {
        $responseBody = new ProductDetailResource(Product::find($request->product_id));
        return $this->successResponse($responseBody, 'Success retrieve product detail');
    }
}
