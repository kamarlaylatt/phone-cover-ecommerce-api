<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
class MaskListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_file(Storage::path('public/uploads/mask_imgs/'.$this->image)))
        {
            $image_url = url(Storage::url('uploads/mask_imgs/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }
        return [
            'charletId' => $this->id,
            'tabId' => $this->tab_id,
            'image' => $image_url,
        ];
    }
}
