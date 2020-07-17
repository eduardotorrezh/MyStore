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
        return BuyAndSell::all();
    }
}
    