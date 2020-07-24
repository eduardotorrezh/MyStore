<?php

namespace App\Http\Controllers;

use App\BuyAndSell;
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
}
    