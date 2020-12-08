<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [];

    public function townships()
    {
        return $this->hasMany('App\Township');
    }

    public function region_infos()
    {
        return $this->hasMany('App\RegionInfo');
    }
}
