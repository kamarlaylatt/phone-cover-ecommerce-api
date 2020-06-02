<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image', 'link', 'show_status', 'text_color'
    ];

    public function infos()
    {
        return $this->hasMany('App\BannerInfo');
    }
}
