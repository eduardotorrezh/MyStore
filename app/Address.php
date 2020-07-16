<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [

        'address','street1','street2','indications','contactphone','user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
}
