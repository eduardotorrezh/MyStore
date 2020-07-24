<?php

namespace App\Http\Controllers;

use App\BuyAndSell;
use App\PaypalId;
use App\ProductsInShoppingCart;
use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyAndSellController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();   
        $status = $user->status;

        if(!$status){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $name_rol = $user->rol()->first()->name;
        

        if($name_rol == 'Client'){
            return response()->json([
                'message' => 'No tienes acceso a este modulo'
            ],404);
        }

        return BuyAndSell::all();
    }

    public function byUserCurr(Request $request)
    {
        $user = Auth::user();  
        $status = $user->status;
        if(!$status){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }
        //return $user;
         $A = BuyAndSell::where('user_id','=', $user->id)->get();
         return $A;
    }


    public function payId(Request $request)
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
        $sc = ShoppingCart::where('user_id','=', $user->id)->where('status', 1)->first();
        $bands = BuyAndSell::where('user_id','=', $user->id)->first();
        $stat = ["status"=>false];
        $stat2 = ["status"=>true];
        $paypal = [
            'pay_id'=>$request->pay_id,
            'sc_id'=>$sc->id,
            'bas_id'=>$bands->id,
        ];

        if($ppid = PaypalId::create($paypal)){
            $csc = ShoppingCart::where('user_id','=', $user->id)->where('status', 1)->get();
            if(ShoppingCart::where('user_id','=', $user->id)->where('status', 1)->update($stat)){
                $bandsc = BuyAndSell::where('user_id','=', $user->id)->where('status', 1)->get();
                if(BuyAndSell::where('user_id','=', $user->id)->where('status', 1)->update($stat2)){
                    $nsc = ["user_id"=>$user->id, "status"=>true];
                    if(ShoppingCart::create($nsc)){
                        return [
                            "ppid"=>$ppid,
                            "csc"=>$csc,
                            "bands"=>$bandsc,
                            "nsc"=>$nsc
                        ];
                    }
                }
            }
        }

        // if($ppid = PaypalId::create($paypal)){
        //     if($csc =ShoppingCart::where('user_id','=', $user->id)->where('status', 1)->update($stat)){
        //         if($bandsc =BuyAndSell::where('user_id','=', $user->id)->update($stat2)){

        //         }
        //     }
        // }
       
        
    }


    public function products_by_cars($id)
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

        $name_rol = $user->rol()->first()->name;

        if($name_rol == 'Client'){
            $order = ShoppingCart::where('id','=', $id)->where('status', 0)->first();

            if(!$order){
                return response()->json([
                    'message' => 'No se encontro carrito'
                ],404);
            }

            $userShopping = $order->user()->first();

            if($user->email != $userShopping->email){
                return response()->json([
                    'message' => 'No tienes acceso a este carrito'
                ],404);
            }
    
            $prods = ProductsInShoppingCart::query()
            ->with('product')->where('shopping_cart_id','=', $order->id)->get();
            return $prods;
        }else{
            $order = ShoppingCart::where('id','=', $id)->where('status', 0)->first();

            if(!$order){
                return response()->json([
                    'message' => 'No se encontro carrito'
                ],404);
            }
    
            $prods = ProductsInShoppingCart::query()
            ->with('product')->where('shopping_cart_id','=', $order->id)->get();
            return $prods;
        }      
    }
}
    