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

    public function getTree()
    {
        $categories = CategoryResource::collection(Category::all());

        $children_array = array();       

        foreach ($categories as $key => $category) {
            if($category->parents == 0)
            {
                array_push($children_array, $category);
            }
        }

        $category_array = [
            [
                'id' => '0',
                'name' => 'root',
                'icon' => 'fa fa-folder',
                'parent' => '',
                'children'=> $children_array,
                'description'=> '',
                'opened' => true,
                'image'=> '',
            ],
            
        ];

        return $category_array;
    }
}
