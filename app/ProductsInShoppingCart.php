<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsInShoppingCart extends Model
{
    protected $fillable = [
        'product_id','shopping_cart_id','quantity','subtotal'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
