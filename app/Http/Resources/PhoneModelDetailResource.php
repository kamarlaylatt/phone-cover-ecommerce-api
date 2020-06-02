<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class PhoneModelDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_file(Storage::path('public/uploads/phone_model_imgs/'.$this->image)))
        {
            $image_url = url(Storage::url('uploads/phone_model_imgs/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }

        if(is_file(Storage::path('public/uploads/phone_model_frame_imgs/'.$this->frame)))
        {
            $frame_url = url(Storage::url('uploads/phone_model_frame_imgs/'.$this->frame));
        }
        else{
            $frame_url = asset('images/default.png');
        }

        return [
            'phone_model_id' => $this->id,
            'name' => $this->name,
            'image' => $image_url,
            'position_x' => $this->position_x,
            'position_y' => $this->position_y,
            'frame_url' => $frame_url,
        ];
    }
}
