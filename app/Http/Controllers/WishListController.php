<?php

namespace App\Http\Controllers;

use App\WishList;
use App\ProductsInWishList;
use App\Http\Resources\ProductsWLCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
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
        $order = WishList::where('user_id','=', $user_id)->get();
        $wl_id = $order[0]->id;
        $prods = ProductsInWishList::where('wish_list_id','=', $wl_id)->get();
        $wl = WishList::find($wl_id);
        return new ProductsWLCollection($wl->products()->get());  
    }

    
    public function destroy(WishList $wishList)
    {
        //
    }
}
