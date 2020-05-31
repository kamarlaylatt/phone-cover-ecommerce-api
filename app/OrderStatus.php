<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name','sort_index','icon','description'
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
