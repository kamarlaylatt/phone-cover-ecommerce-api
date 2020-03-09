<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $product_infos = $this->infos->where('language_id', $request->language_id)->first();
        return [
            'banner_id' => $this->id,
            'image' => url(\Storage::url('uploads/banner_imgs/'.$this->image)),
            'url' => $this->link,
            'title' => $product_infos->title,
            'subtitle' => $product_infos->subtitle,
            'buttonText' => $product_infos->button_text,
        ];
    }
}
