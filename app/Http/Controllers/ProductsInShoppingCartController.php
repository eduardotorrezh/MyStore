<?php

namespace App\Http\Controllers;

use App\ProductsInShoppingCart;
use App\Product;
use App\ShoppingCart;
use Illuminate\Http\Request;

class ProductsInShoppingCartController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $user_id =  $request->user_id;
        $order = ShoppingCart::where('user_id','=', $user_id)->get();
        $sc_id = $order[0]->id;
        $prod = Product::find($request->product_id);
        $subtotal;
        if($request->quantity>1){
            $subtotal = $prod->final_price * $request->quantity;
        }else{
            $subtotal = $prod->final_price; 
        }
        $psc = [
            'product_id'=> $request->product_id,
            'shopping_cart_id'=>$sc_id,
            'quantity'=>$request->quantity,
            'subtotal'=>$subtotal
        ];
        if(ProductsInShoppingCart::create($psc)){
            return 200;
        }else{
            return 'Algo no ha salido bien';
        }
        
        
    }

    public function update(Request $request)
    {
        $user_id =  $request->user_id;
        $order = ShoppingCart::where('user_id','=', $user_id)->where('status', 1)->get();
        $sc_id = $order[0]->id;
        $pisc = ProductsInShoppingCart::where('shopping_cart_id','=', $sc_id)->where('product_id', $request->product_id)->get();
        $pisc = $pisc[0];
        $pr  = Product::find($request->product_id);
        
        //$pisc = Product
        if($pisc->quantity != $request->quantity){
            $pisc->quantity = $request->quantity;
            $pisc->subtotal = $request->quantity * $pr->final_price;
            if($pisc->save()){
                return 200;
            }else{
                return "Algo salió mal";
            }
        }
    }
  
    public function destroy(Request $request)
    {
        $user_id =  $request->user_id;
        $order = ShoppingCart::where('user_id','=', $user_id)->get();
        $sc_id = $order[0]->id;
        $prod_id = $request->product_id;
        
        if(ProductsInShoppingCart::where('shopping_cart_id', $sc_id)
        ->where('product_id', $prod_id)->delete()){
            return 200;
        }else{
            return 'Algo salió mal';
        }


    }
}
