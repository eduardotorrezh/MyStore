<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsInWishList extends Model
{
    protected $fillable = [
        'product_id','wish_list_id'
    ];
}
