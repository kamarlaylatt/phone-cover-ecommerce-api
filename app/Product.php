<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'price','qty','min_order','max_order','recomand','image','seo_key','fb_pixel',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }


}
