<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChildrenResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
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
        return $this->collection->map(function(ChildrenResource $resource) use($request){
            return $resource->language_id($this->language_id)->toArray($request);
        })->all();

        return parent::toArray($request);
    }
}
