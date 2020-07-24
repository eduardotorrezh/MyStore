<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [

        'city','street','zip_code','country','state', 'phone_number', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
}
