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
        if($request->recommend_status == 1)
        {
            return new ProductListResourceCollection(Product::where('recommend',1)->paginate(20));
        }

        $category = Category::find($request->category_id);
        if($category)
        {
            return new ProductListResourceCollection($category->products()->paginate(20));
        }else{
            return new ProductListResourceCollection(Product::paginate(20));
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

    public function getRelatedProduct(Request $request)
    {
        $categories = explode(',', $request->categories);

        $products = Product::whereHas('categories',function($query)use($categories){
                                    $query->whereIn('category_id',$categories);
                                })
                                ->where('id', '!=', $request->product_id)
                                ->limit(8)
                                ->get();
        $responseBody = ProductListResource::Collection($products);

        return $this->successResponse($responseBody, 'Success retrieve related products');

    }

    public function getRecommendProduct(Request $request)
    {
        return new ProductListResourceCollection(Product::where('recommend',1)->paginate(20));
    }

    public function searchProductList(Request $request)
    {
        $rules = [
            'search' => 'required',
        ];

        $validation = $this->validateResponse($request->all(), $rules);
        if($validation['validate_status'] == 1)
        {
            return $validation;
        }
        $products = Product::where('code_number','like','%'.$request->search.'%')
                            ->orWhereHas('infos', function($q) use($request){
                                $q->where('name','like','%'.$request->search.'%')
                                ->where('language_id',$request->language_id);              
                            })
                            ->get();
        $responseBody = ProductListResource::Collection($products);
        return $this->successResponse($responseBody, 'Success retrieve related products');
    }
}
