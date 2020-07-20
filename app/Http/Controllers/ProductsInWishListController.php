<?php

namespace App\Http\Controllers;
use App\WishList;
use App\ProductsInWishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsInWishListController extends Controller
{

    public function store(Request $request)
    {
        $user = Auth::user();   
        $status = $user->status;

        if(!$status){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $user_id =  $user->id;
        $order = WishList::where('user_id','=', $user_id)->get();
        $wl_id = $order[0]->id;
        $prod_id = $request->product_id;
        $pw = [
            'product_id' => $prod_id,
            'wish_list_id' => $wl_id
        ];
            if(ProductsInWishList::create($pw)){
                return response()->json([
                    'message' => 'Producto agregado exitosamente'
                ],200);
            }else{
                return response()->json([
                    'message' => 'Ha ocurrido un problema'
                ],404);
            }
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();   
        $status = $user->status;

        if(!$status){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $user_id =  $user->id;
        $order = WishList::where('user_id','=', $user_id)->get();
        $wl_id = $order[0]->id;
        $prod_id = $request->product_id;
        
        if(ProductsInWishList::where('wish_list_id', $wl_id)
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
