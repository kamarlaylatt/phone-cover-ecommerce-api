<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShellMaterial extends Model
{
    protected $fillable = [
        'name','price','sort_index'
    ];
}
