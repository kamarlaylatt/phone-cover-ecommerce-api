<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderItemListResource;
use App\OrderItem;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
            'order_no' => $this->order_no,
            'order_status' => $this->order_status->name,
            'item_count' => $this->item_count,
            'total_amount' => (double)$this->total_amount,
            'order_items' => OrderItemListResource::collection(OrderItem::where('order_id',$this->id)->get()),
        ];
    }
}
