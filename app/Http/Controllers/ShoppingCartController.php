<?php

namespace App\Http\Controllers;
use App\ProductsInShoppingCart;
use App\ShoppingCart;
use App\BuyAndSell;
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

    public function pay_sc(Request $request)
    {
        $user_id =  $request->user_id;

        $order = ShoppingCart::where('user_id','=', $user_id)->where('status', 1)->first();
        $prods = ProductsInShoppingCart::where('shopping_cart_id','=', $order->id)->get();
        $total_sc=0;
        foreach ($prods as $v) {
            $total_sc = $total_sc + $v->subtotal;
        }
        $pay=[
            "user_id"=>$user_id,
            "sc_id"=>$order->id,
            "status"=>true,
            "cart_total"=>$total_sc
        ];
        $stat = ["status"=>false];
        if(BuyAndSell::create($pay)){
            $asc = ShoppingCart::find($order->id);

            if(ShoppingCart::where('id','=', $order->id)->update($stat)){
                $nsc = [ "user_id"=> $user_id, "status"=>true];
                $DSA = ShoppingCart::create($nsc);
                $ret = [
                    "new_sc"=>$DSA,
                    "pay"=>$pay,
                    "message"=>"Carrito ha pasado a pagados. "
                ];
                return $ret;
            }
        }
        
        return "Algo salió mal";
        
    }

    

    
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }
}
