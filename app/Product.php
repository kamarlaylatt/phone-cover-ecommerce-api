<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    	Product::Create([
    		'code_number' => $request['code_number'],
    		'price' => $request['price'],
    		'qty' => $request['quantity'],
    		'min_order' => $request['minimum_order'],
    		'max_order' => $request['maximum_order'],
    		'recommend' => $request['recommend'],
    	]);

    	return ['success' => true];
    }


}
