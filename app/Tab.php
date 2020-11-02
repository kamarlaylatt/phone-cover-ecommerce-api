<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    protected $fillable = [
        'name','sort_index'
    ];
}
