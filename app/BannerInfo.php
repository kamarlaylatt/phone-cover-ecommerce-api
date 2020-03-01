<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerInfo extends Model
{
    protected $fillable = [
        'title','subtitle','button_text','banner_id', 'language_id',
    ];
}
