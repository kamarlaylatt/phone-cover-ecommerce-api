<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\CategoryResource;

class Category extends Model
{
    protected $fillable = [
        'name', 'image', 'parents','description',
    ];

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

    public function getChildrenTree()
    {
        $categories = CategoryResource::collection(Category::where('parents', 0)->get());

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
