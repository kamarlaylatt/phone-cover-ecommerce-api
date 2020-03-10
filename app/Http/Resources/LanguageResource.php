<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_file(Storage::path('public/uploads/language_imgs/'.$this->icon)))
        {
            $icon_url = url(Storage::url('uploads/language_imgs/'.$this->icon));
        }
        else{
            $icon_url = asset('images/default.png');
        }
        return [
            'id' => $this->id,
            'icon' => $icon_url,
            'alias' => $this->alias,
            'name' => $this->name,
        ];
    }
}
