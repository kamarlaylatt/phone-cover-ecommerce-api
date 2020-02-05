<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\CategoryResource;

class Category extends Model
{
    protected $fillable = [
        'image', 'parents',
    ];

    public function category_infos()
    {
        return $this->hasMany('App\CategoryInfo');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function children()
    {
    	return $this->hasMany('App\Category', 'parents');
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parents');
    }

    public function getChildrenTree($language_id = 1)
    {
        $categories = CategoryResource::collection(Category::where('parents', 0)->get())->language_id($language_id);

        $category_array = [
            [
                'id' => 0,
                'name' => 'root',
                'icon' => 'fa fa-folder',
                'parent' => '',
                'children'=> $categories,
                'description'=> '',
                'opened' => true,
                'image'=> '',
            ],
            
        ];

        return $category_array;
    }
}
