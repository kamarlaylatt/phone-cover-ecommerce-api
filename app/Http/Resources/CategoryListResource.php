<?php

namespace App\Http\Resources;

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
        $category_info = $this->category_infos->where('language_id', $request->language_id)->first();

        if(is_file(Storage::path('public/uploads/category_imgs/'.$this->icon)))
        {
            $image_url = url(Storage::url('uploads/category_imgs/'.$this->icon));
        }
        else{
            $image_url = asset('images/default.png');
        }

        return [
            'category_id' => $this->id,
            'image' => $image_url,
            'name' => $category_info->name,
        ];
    }
}
