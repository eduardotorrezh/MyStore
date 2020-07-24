<?php

namespace App\Http\Controllers;

use App\BuyAndSell;
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

        $A = BuyAndSell::where('user_id','=', $user->user_id)->get();
        return $A;
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
    