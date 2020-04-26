<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class RecruitmentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $recruitment_info = $this->infos->where('language_id', $request->language_id)->first();

        if(is_file(Storage::path('public/uploads/recruitment_imgs/'.$this->image)))
        {
            $image_url = url(Storage::url('uploads/recruitment_imgs/'.$this->image));
        }
        else{
            $image_url = asset('images/default.png');
        }
        return [
            'recruitmentId' => $this->id,
            'image' => $image_url,
            'sortIndex' => $this->sort_index,
            'title' => $recruitment_info->title,
            'description' => $recruitment_info->description,
        ];
    }
}
