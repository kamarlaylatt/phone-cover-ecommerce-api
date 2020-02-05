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
    private $language_id;

    public function __construct($resource, $value){
        parent::__construct($resource);
        $this->resource = $resource;
        $this->language_id = $value;
        return $this->language_id;
    }
    
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->category_infos[0]->name,
            'icon' => 'fa fa-folder',
            'parent' => $this->parents,
            'children'=> ChildrenResource::collection($this->children),
            'description'=> $this->category_infos[0]->description,
            'image'=> $this->category_infos[0]->image,
            'language_id' => $this->language_id,
        ];
    }
}
