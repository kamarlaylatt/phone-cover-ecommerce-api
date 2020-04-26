<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intension extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'type',
        'phone_model_id',
        'shell_material_id',
        'preview',
        'price',
        'print_status',
        'remark',
    ];

    public function phone_model()
    {
        $this->belongsTo('App\PhoneModel','phone_model_id');
    }

    public function shell_material()
    {
        $this->belongsTo('App\ShellMaterial','shell_material_id');
    }

    public function intension_images()
    {
        $this->belongsTo('App\IntensionImage');
    }
}
