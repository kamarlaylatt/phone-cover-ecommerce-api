<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charlet extends Model
{
    protected $fillable = [
        'image','tab_id','sort_index'
    ];

    public function tab()
    {
        return $this->belongsTo('App\Tab','tab_id');
    }
}
