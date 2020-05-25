<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductImagesResource;
use App\Http\Resources\ProductAdditionsResource;
use App\Http\Resources\ProductListResource;
use App\Product;

use Storage;

class ProductDetailResource extends JsonResource
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
            'product_name' => $product_info->name,
            'product_code' => $this->code_number,
            'recommend' => $this->recommend,
            'thumbnail' => $image_url,
            'price' => $this->price,
            'short_description' => $this->short_description,
            'description' => $product_info->description,
            'fb_pixel' => $this->fb_pixel,
            'seo_key' => $this->seo_key,
            'category' => CategoryListResource::collection($this->categories),
            'images' => ProductImagesResource::collection($this->images),
            'attributes' => ProductAdditionsResource::collection($this->additions->where('language_id', $request->language_id)),
        ];
    }
}
