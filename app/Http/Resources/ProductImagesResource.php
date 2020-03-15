<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class ProductImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_file(Storage::path('public/uploads/product_imgs/images/'.$this->image)))
        {
            $image_url = url(Storage::url('uploads/product_imgs/images/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }

        return [
            'image_id' => $this->id,
            'image' => $image_url,
            'sort_no' =>$this->sort_no,
        ];
    }
}
