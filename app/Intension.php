<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Intension extends Model
{
    use Sortable;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'order_no',
        'type',
        'phone_model_id',
        'shell_material_id',
        'preview',
        'price',
        'order_status_id',
        'remark',
        'delivery_cost',
        'total_net',
        'pay_amount',
        'remain_amount'
    ];

    public $sortable = [
        'user_id',
        'name',
        'phone',
        'address',
        'order_no',
        'type',
        'phone_model_id',
        'shell_material_id',
        'preview',
        'price',
        'order_status_id',
        'remark',
    ];

    public function phone_model()
    {
        return $this->belongsTo('App\PhoneModel','phone_model_id');
    }

    public function shell_material()
    {
        return $this->belongsTo('App\ShellMaterial','shell_material_id');
    }

    public function intension_images()
    {
        return $this->hasMany('App\IntensionImage');
    }

    public function order_status()
    {
        return $this->belongsTo('App\OrderStatus','order_status_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
