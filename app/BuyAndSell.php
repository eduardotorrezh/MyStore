<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyAndSell extends Model
{
    protected $fillable = [
        'user_id','sc_id','status','cart_total'
    ];
}
