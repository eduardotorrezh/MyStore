<?php

namespace App\Http\Controllers;
use App\ProductsInShoppingCart;
use App\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    
    public function show(Request $request)
    {
        $user_id =  $request->user_id;
        $order = ShoppingCart::where('user_id','=', $user_id)->where('status', 1)->first();
        $prods = ProductsInShoppingCart::where('shopping_cart_id','=', $order->id)->get();
        return $prods;
    }

    
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }
}
