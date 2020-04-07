<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecruitmentInfo extends Model
{
    protected $fillable = [
        'recruitment_id','language_id','title','description'
    ];
}
