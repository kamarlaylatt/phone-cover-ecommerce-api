<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id','item_id','item_type','qty','sub_total'
    ];

    public function order()
    {
        $this->belongsTo('App\Order','order_id');
    }

    public function item()
    {
        return $this->morphTo();
    }
}
