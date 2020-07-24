<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalId extends Model
{
    protected $fillable = [
        'pay_id','sc_id','bas_id'
    ];
}
