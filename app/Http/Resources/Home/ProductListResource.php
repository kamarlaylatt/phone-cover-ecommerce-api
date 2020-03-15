<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Home\CategoryListResource;
use Storage;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product_info = $this->infos->where('language_id', $request->language_id)->first();

        if(is_file(Storage::path('public/uploads/product_imgs/thumbnail/'.$this->image)))
        {
            $image_url = url(Storage::url('uploads/product_imgs/thumbnail/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }

        return [
            'product_id' => $this->id,
            'codeNo' => $this->code_number,
            'thumbnail' => $image_url,
            'price' => $this->price,
            'categories' => CategoryListResource::collection($this->categories),
        ];
    }
}
