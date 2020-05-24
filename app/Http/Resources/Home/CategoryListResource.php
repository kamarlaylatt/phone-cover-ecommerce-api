<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
        // $category_info = $this->category_infos->where('language_id', $request->language_id)->first();
        return [
            'category_id' => $this->id,
            'name' => $this->name,
        ];
    }
}
