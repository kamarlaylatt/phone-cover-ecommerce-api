<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
class IntensionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_file(Storage::path('public/orders/images/'.$this->preview)))
        {
            $image_url = url(Storage::url('orders/images/'.$this->preview));
        }
        else{
            $image_url = asset('images/default.png');
        }

        return [
            'intension_id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'order_no' => $this->order_no,
            'type' => $this->type,  
            'phone_model' => $this->phone_model->name,
            'shell_material' => $this->shell_material->name, 
            'price' => $this->price,
            'delivery_cost' => $this->delivery_cost,
            'net_amount' => $this->total_net,
            'pay_amount' => $this->pay_amount,
            'remain_amount' => $this->remain_amount,    
            'order_status' => $this->order_status->name,   
            'preview' => $image_url,
            'remark' => $this->remark,
            'type' => $this->type,
        ];
    }
}
