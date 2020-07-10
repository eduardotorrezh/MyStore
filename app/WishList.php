<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product','products_in_wish_lists');
    }

    public function productsCount()
    {
        return $this->products()->count();
    }
}
