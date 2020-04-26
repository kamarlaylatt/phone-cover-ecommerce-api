<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_status_id','user_id','item_count','total_amount','remark','order_no'
    ];

    public function user()
    {
        $this->belongsTo('App\User', 'user_id');
    }

    public function order_status()
    {
        $this->belongsTo('App\OrderStatus','order_status_id');
    }

    public function order_items()
    {
        $this->hasMany('App\OrderItem');
    }
}
