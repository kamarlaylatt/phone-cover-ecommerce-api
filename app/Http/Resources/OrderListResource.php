<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'order_status' => $this->order_status->name,
            'user_name' => $this->user->name,
            'item_count' => $this->item_count,
            'total_amount' => $this->total_amount,
            'remark' => $this->remark,
            'order_no' => $this->order_no,
            'order_time' => date($this->created_at),
        ];
    }
}
