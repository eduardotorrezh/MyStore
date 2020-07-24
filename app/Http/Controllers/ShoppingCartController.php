<?php

namespace App\Http\Controllers;
use App\ProductsInShoppingCart;
use App\ShoppingCart;
use App\BuyAndSell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ShoppingCartController extends Controller
{
    
    public function show(Request $request)
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
        $order = ShoppingCart::where('user_id','=', $user_id)->where('status', 1)->first();
        $prods = ProductsInShoppingCart::query()
        ->with('product')->where('shopping_cart_id','=', $order->id)->get();
        return $prods;
    }

    public function pay_sc(Request $request)
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

        $order = ShoppingCart::where('user_id','=', $user_id)->where('status', 1)->first();
        $prods = ProductsInShoppingCart::where('shopping_cart_id','=', $order->id)->get();
        $total_sc=0;
        foreach ($prods as $v) {
            $total_sc = $total_sc + $v->subtotal;
        }
        $pay=[
            "user_id"=>$user_id,
            "sc_id"=>$order->id,
            "status"=>false,
            "cart_total"=>$total_sc
        ];
        //$stat = ["status"=>false];

        if(BuyAndSell::create($pay)){
            $asc = ShoppingCart::find($order->id);

            try{
                Mail::send('purchases',['user' => $user],function($message) use ($user){
                    $message->from('mystorebusiness9@gmail.com','My Store');
                    $message->to($user->email)->subject('Aviso de compra');
                });
            }catch(Exception $ex){
                return response()->json([
                    'message' => 'No se pudo realizar el envio'
                ],404);
            }

            $ret = [
                "pay"=>$pay,
                "message"=>"Se está procesando el pago."
            ];
            return $ret;

            // if(ShoppingCart::where('id','=', $order->id)->update($stat)){
            //     $nsc = [ "user_id"=> $user_id, "status"=>true];
            //     $DSA = ShoppingCart::create($nsc);
            //     $ret = [
            //         "new_sc"=>$DSA,
            //         "pay"=>$pay,
            //         "message"=>"Carrito ha pasado a pagados. "
            //     ];
            //     return $ret;
            // }
        }
        
        return response()->json([
            'message' => 'Ha ocurrido un problema'
        ],404);
    
        
    }

    

    
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }
}
