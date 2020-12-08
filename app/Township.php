<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    protected $fillable = [
        'delivery_price','region_id'
    ];

    public function township_infos()
    {
        return $this->hasMany('App\TownshipInfo');
    }

    public function region()
    {
        return $this->belongsTo('App\Region','region_id');
    }
}
