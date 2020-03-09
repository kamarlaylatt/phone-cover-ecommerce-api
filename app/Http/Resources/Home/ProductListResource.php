<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Home\CategoryListResource;

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
        return [
            'product_id' => $this->id,
            'categories' => CategoryListResource::collection($this->categories),
            'codeNo' => $this->code_number,
            'thumbnail' => url(\Storage::url('uploads/product_imgs/thumbnail/'.$this->image)),
            'price' => $this->price,
        ];
    }
}
