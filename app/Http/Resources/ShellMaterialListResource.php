<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShellMaterialListResource extends JsonResource
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
            'shellMaterialId' => $this->id,
            'name' => $this->name,
            'sortIndex' => $this->sort_index,
        ];
    }
}
