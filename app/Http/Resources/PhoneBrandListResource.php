<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class PhoneBrandListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_file(Storage::path('public/uploads/phone_brand_imgs/'.$this->image)))
        {
            $image_url = url(Storage::url('uploads/phone_brand_imgs/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }
        return [
            'phoneBrandId' => $this->id,
            'name' => $this->name,
            'image' => $image_url,
        ];
    }
}
