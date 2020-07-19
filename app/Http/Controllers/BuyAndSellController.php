<?php

namespace App\Http\Controllers;

use App\BuyAndSell;
use Illuminate\Http\Request;

class BuyAndSellController extends Controller
{
    
    public function index()
    {
        return BuyAndSell::all();
    }

    public function byUser(Request $request)
    {
        $A = BuyAndSell::where('user_id','=', $request->user_id)->get();
        return $A;
    }
}
    