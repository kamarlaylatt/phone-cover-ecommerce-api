<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $fillable = [
        'image','sort_index','created_by_id'
    ];

    public function infos()
    {
        return $this->hasMany('App\RecruitmentInfo');
    }
}
