<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneModel extends Model
{
    protected $fillable = [
        'name','image','phone_brand_id','width','height','position_x','position_y','frame'
    ];

    public function phone_brand()
    {
        return $this->belongsTo('App\PhoneBrand');
    }
}
