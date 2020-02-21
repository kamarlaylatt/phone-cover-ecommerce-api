<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductInfo;
use App\ProductAddition;
use App\Category;
use App\ProductImage;
use Storage;
use Image;

class Product extends Model
{
    protected $fillable = [
        'code_number','price','qty','min_order','max_order','recommend','image','seo_key','fb_pixel',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function infos()
    {
        return $this->hasMany('App\ProductInfo');
    }

    public function storeProduct($request)
    {
    	$product = Product::Create([
    		'code_number' => $request['code_number'],
    		'price' => $request['price'],
    		'qty' => $request['quantity'],
    		'min_order' => $request['minimum_order'],
    		'max_order' => $request['maximum_order'],
    		'recommend' => $request['recommend'],
    	]);

        $category = Category::find(json_decode($request['category_array']));
        $product->categories()->attach($category);

        $images = json_decode($request['images']);

        foreach ($images as $key => $image) {
            $filename = uniqid().'_'.$image->name;
            
            Image::make($image->path)->encode()->save(storage_path('app/public/uploads/product_imgs/images/').$filename);

            
            $product_image = ProductImage::Create([
                'product_id' => $product->id,
                'image' => $filename,
                'sort_no' => $key+1,
            ]);


            
        }

        ProductInfo::Create([
            'product_id' => $product->id,
            'language_id' => 1,
            'name' => $request['english_name'],
            'description' => $request['english_description'],
        ]);

        ProductInfo::Create([
            'product_id' => $product->id,
            'language_id' => 2,
            'name' => $request['myanmar_name'],
            'description' => $request['myanmar_description'],
        ]);

        $english_additions = json_decode($request['english_additions']);
        foreach ($english_additions as $addition) {
            ProductAddition::Create([
                'product_id' => $product->id,
                'language_id' => 1,
                'key' => $addition->key,
                'value' => $addition->value,
            ]);
        }

        $myanmar_additions = json_decode($request['myanmar_additions']);
        foreach ($myanmar_additions as $addition) {
            ProductAddition::Create([
                'product_id' => $product->id,
                'language_id' => 2,
                'key' => $addition->key,
                'value' => $addition->value,
            ]);
        }


    	return [
            'success' => true,
            'product_id' => $product->id,
        ];
    }


}
