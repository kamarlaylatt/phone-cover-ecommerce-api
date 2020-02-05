<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChildrenResource;
use App\CategoryInfo;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected $language_id;

    public function language_id($value){
        $this->language_id = $value;
        return $this;
    }
    
    public function toArray($request)
    {        
        $category_infos = $this->category_infos->where('language_id',$this->language_id)->first();
        // $language_id = $request['language_id'];

        return [
            'id' => $this->id,            
            'icon' => 'fa fa-folder',
            'parent' => $this->parents,
            'name' => $category_infos->name,
            'description' => $category_infos->description,
            'image' => $this->image,
            'children'=> ChildrenResource::collection($this->children)->language_id($this->language_id),
        ];
    }

    public static function collection($resource){
        return new CategoryResourceCollection($resource);
    }
}
