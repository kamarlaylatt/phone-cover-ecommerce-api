<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use Sortable;

    protected $fillable = [
        'order_status_id','user_id','item_count','total_amount','remark','order_no','delivery_cost','total_net','pay_amount','remain_amount'
    ];

    public $sortable = [
        'order_status_id','user_id','item_count','total_amount','remark','order_no'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function order_status()
    {
        return $this->belongsTo('App\OrderStatus','order_status_id');
    }

    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }
}
