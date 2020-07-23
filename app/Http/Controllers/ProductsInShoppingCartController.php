<?php

namespace App\Http\Controllers;

use App\ProductsInShoppingCart;
use App\Product;
use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario logeado'
            ],401);
        }

        $status = $user->status;

        if(!$status){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $user_id =  $user->id;
        $order = ShoppingCart::where('user_id','=', $user_id)->get();
        $sc_id = $order[0]->id;
        
        $test = ProductsInShoppingCart::where('shopping_cart_id','=', $sc_id)->where('product_id',$request->product_id)->get();
        
        if(count($test) == 0){
            $prod = Product::find($request->product_id);
            $subtotal;
            if($request->quantity>1){
                $subtotal = $prod->final_price * $request->quantity;
            }else{
                $subtotal = $prod->final_price; 
            }
            $psc = [
                'product_id'=> $request->product_id,
                'shopping_cart_id' => $sc_id,
                'quantity' => $request->quantity,
                'subtotal' => $subtotal
            ];
            if(ProductsInShoppingCart::create($psc)){
                return response()->json([
                    'message' => 'Producto agregado exitosamente'
                ],200);
            }else{
                return response()->json([
                    'message' => 'Ha ocurrido un problema'
                ],404);
            }    
        }else{
            return response()->json([
                'message' => 'El producto está repetido'
            ],404);
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario logeado'
            ],401);
        }

        $status = $user->status;

        if(!$status){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $user_id =  $user->id;
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
                return response()->json([
                    'message' => 'Producto actualizado exitosamente'
                ],200);
            }else{
                return response()->json([
                    'message' => 'Ha ocurrido un problema'
                ],404);
            }
        }
    }
  
    public function destroy(Request $request)
    {
        $user = Auth::user();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario logeado'
            ],401);
        }

        $status = $user->status;

        if(!$status){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $user_id =  $user->id;
        $order = ShoppingCart::where('user_id','=', $user_id)->get();
        $sc_id = $order[0]->id;
        $prod_id = $request->product_id;
        
        if(ProductsInShoppingCart::where('shopping_cart_id', $sc_id)
        ->where('product_id', $prod_id)->delete()){
            return response()->json([
                'message' => 'Producto eliminado exitosamente'
            ],200);
        }else{
            return response()->json([
                'message' => 'Ha ocurrido un problema'
            ],404);
        }
    }
}
