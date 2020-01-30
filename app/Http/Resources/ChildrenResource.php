<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildrenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => 'fa fa-folder',
            'parent' => $this->parents,
            'children'=> ChildrenResource::collection($this->children),
            'description'=> $this->description,
            'image'=> $this->image,
        ];
    }
}
