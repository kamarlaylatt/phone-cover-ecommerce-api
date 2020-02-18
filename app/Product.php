<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductInfo;
use App\ProductAddition;

class Product extends Model
{
    protected $fillable = [
        'code_number','price','qty','min_order','max_order','recommend','image','seo_key','fb_pixel',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
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

        $english_additions = $request['english_additions'];
        foreach ($english_additions as $addition) {
            ProductAddition::Create([
                'product_id' => $product->id,
                'language_id' => 1,
                'key' => $addition['key'],
                'value' => $addition['value'],
            ]);
        }

        $myanmar_additions = $request['myanmar_additions'];
        foreach ($myanmar_additions as $addition) {
            ProductAddition::Create([
                'product_id' => $product->id,
                'language_id' => 2,
                'key' => $addition['key'],
                'value' => $addition['value'],
            ]);
        }


    	return ['success' => true];
    }


}
