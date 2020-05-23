<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class SubCategoryListResource extends JsonResource
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

        if(is_file(Storage::path('public/uploads/category_imgs/'.$this->image)))
        {
            $image_url = url(Storage::url('public/uploads/category_imgs/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }

        return [
            'category_id' => $this->id,
            'image' => $image_url,
            'name' => $category_info->name,
            'subCategoryList' => SubCategoryListResource::collection($this->children),
        ];
    }
}
