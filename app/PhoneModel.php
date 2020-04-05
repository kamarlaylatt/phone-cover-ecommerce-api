<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneModel extends Model
{
    protected $fillable = [
        'name','image','phone_brand_id'
    ];
}
