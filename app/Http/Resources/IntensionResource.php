<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'intension_id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'type' => $this->type,  
            'phone_model' => $this->phone_model->name,
            'shell_material' => $this->shell_material->name, 
            'price' => $this->price,    
            'order_status' => $this->order_status->name,   
            'preview' => $this->preview,
            'remark' => $this->remark,
            'type' => $this->type,
        ];
    }
}
