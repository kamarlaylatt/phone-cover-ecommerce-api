<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAddition extends Model
{
    protected $fillable = [
        'product_id','language_id','key','value'
    ];
}
