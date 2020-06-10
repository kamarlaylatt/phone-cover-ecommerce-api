<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtpCheck extends Model
{
    protected $fillable = [
        'phone','otp_code'
    ];
}
