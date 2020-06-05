<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

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
        if(is_file(Storage::path('public/uploads/category_imgs/'.$this->image)))
        {
            $image_url = url(Storage::url('public/uploads/category_imgs/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }
        return [
            'category_id' => $this->category_id,
            'name' => $this->name,
            'image' => $image_url,
        ];
    }
}
