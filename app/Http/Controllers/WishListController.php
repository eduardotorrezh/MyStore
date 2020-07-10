<?php

namespace App\Http\Controllers;

use App\WishList;
use App\ProductsInWishList;
use App\Http\Resources\ProductsWLCollection;
use Illuminate\Http\Request;

class WishListController extends Controller
{
   
    public function show(Request $request)
    {
        $user_id =  $request->user_id;
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
