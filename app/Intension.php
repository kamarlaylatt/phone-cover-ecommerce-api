<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intension extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
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
        return $this->belongsTo('App\IntensionImage');
    }

    public function order_status()
    {
        return $this->belongsTo('App\OrderStatus','order_status_id');
    }
}
