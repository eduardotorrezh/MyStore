<?php

namespace App\Http\Controllers;
use App\WishList;
use App\ProductsInWishList;
use Illuminate\Http\Request;

class ProductsInWishListController extends Controller
{

    public function store(Request $request)
    {
        $user_id =  $request->user_id;
        $order = WishList::where('user_id','=', $user_id)->get();
        $wl_id = $order[0]->id;
        $prod_id = $request->product_id;
        $pw = [
            'product_id' => $prod_id,
            'wish_list_id' => $wl_id
        ];
            if(ProductsInWishList::create($pw)){
                return 200;
            }else{
                return 'Algo salió mal';
            }       
    }

    public function destroy(Request $request)
    {
        $user_id =  $request->user_id;
        $order = WishList::where('user_id','=', $user_id)->get();
        $wl_id = $order[0]->id;
        $prod_id = $request->product_id;
        
        if(ProductsInWishList::where('wish_list_id', $wl_id)
        ->where('product_id', $prod_id)->delete()){
            return 200;
        }else{
            return 'Algo salió mal';
        }
    }
}
