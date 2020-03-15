<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryListResource;

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
            'product_name' => $product_info->name,
            'product_code' => $this->code_number,
            'thumbnail' => $this->image,
            'price' => $this->price,
            'category' => CategoryListResource::collection($this->categories),
        ];
    }
}
