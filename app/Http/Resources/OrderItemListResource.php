<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class OrderItemListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product_info = $this->item->infos->where('language_id', $request->language_id)->first();

        if(is_file(Storage::path('public/uploads/product_imgs/thumbnail/'.$this->item->image)))
        {
            $image_url = url(Storage::url('uploads/product_imgs/thumbnail/'.$this->item->image));
        }
        else{
            $image_url = asset('images/default.png');
        }

        return [
            'order_item_id' => $this->id,
            'item_name' => $product_info->name,
            'image' => $image_url,
            'item_price' => $this->sub_total/$this->quantity,
            'quantity' => $this->quantity,
            'sub_total' => (double)$this->sub_total,

        ];
    }
}
