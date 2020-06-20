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
            return new ProductListResourceCollection(Product::where('recommend',1)->paginate(10));
        }

        $category = Category::find($request->category_id);
        if($category)
        {
            return new ProductListResourceCollection($category->products()->paginate(10));
        }else{
            $products = new Product;

            switch ($request->sort_by_status) {
                case "1":
                    $products = $products->orderBy('price','asc');
                    break;
                case "2":
                    $products = $products->orderBy('price','desc');
                  break;
                case "3":
                    $products = $products->orderBy('id','desc');
                  break;
                default:
                  $products;
            }

            switch ($request->price_status) {
                case "1":
                    $products = $products->whereBetween('price',[0,1000]);
                    break;
                case "2":
                    $products = $products->whereBetween('price',[1000,5000]);
                    break;
                case "3":
                    $products = $products->whereBetween('price',[5000,10000]);
                    break;
                case "4":
                    $products = $products->whereBetween('price',[10000,20000]);
                    break;
                case "5":
                    $products = $products->where('price','>', 20000);
                    break;
                default:
                  $products;
            }
            
            return new ProductListResourceCollection($products->paginate(10));
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
