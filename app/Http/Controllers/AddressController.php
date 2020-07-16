<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Address;
use App\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::where('id','=',$user_id)->where('status','=',true)->first();

       
        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $address = $user->address()->get();

        if(!$address){
            return response()->json([
                'message' => 'Lo sentimos, no hay direcciónes'
            ],404);
        }

        return $address;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $address=[
        //     'address' => $request->address,
        //     'user_id' => $request->user_id,
        // ];
        // if(Address::create($address)){
        //     return 200;
        // }else{
        //     return 'Algo salió mal';
        // }
        $user_id = $request->user_id;
        $user = User::where('id','=',$user_id)->where('status','=',true)->first();

       
        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $address=[
            'address' => $request->address,
            'street1' => $request->street1,
            'street2' =>  $request->street2,
            'indications' =>  $request->indications,
            'contactphone' =>  $request->contactphone,
            'user_id' => $user_id,
        ];

        if(Address::create($address)){
            return response()->json([
                'message' => 'Dirección guardada exitosamente',
                'address' => $address 
            ],201);
        }else{
            return response()->json([
                'message' => 'Ha ocurrido un problema'
            ],404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        // $address = Address::where('user_id','=', $user_id)->get();
        // return  $address; 

        $user_id = $request->user_id;
        $user = User::where('id','=',$user_id)->where('status','=',true)->first();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario logeado'
            ],404);
        }


        $user = $user->where('status','=',true)->first();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $address = $user->address()->where('id','=',$id)->first();

        if(!$address){
            return response()->json([
                'message' => 'Lo sentimos, no se encontro dirección'
            ],404);
        }

        return $address;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $address =  Address::find($id);
        // $address -> address = $request -> address;
        // if($address->save()){
        //     return 200;
        // }else{
        //     return 'Algo salió mal';
        // }

        $user_id = $request->user_id;
        $user = User::where('id','=',$user_id)->where('status','=',true)->first();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario logeado'
            ],404);
        }


        $user = $user->where('status','=',true)->first();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $address = $user->address()->where('id','=',$id)->first();

        if(!$address){
            return response()->json([
                'message' => 'Lo sentimos, no se encontro dirección'
            ],404);
        }

        $address -> address = $request->address;
        $address -> street1 = $request->street1;
        $address -> street2 =  $request->street2;
        $address -> indications =  $request->indications;
        $address -> contactphone =  $request->contactphone;
        $address -> user_id = $user_id;

        if($address->save()){
            return response()->json([
                'message' => 'Dirección actualizada exitosamente',
                'address' => $address
            ],200);
        }else{
            return response()->json([
                'message' => 'Ha ocurrido un problema'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id )
    {
        // Address::destroy($id);
        // return 'Borrado';

        $user_id = $request->user_id;
        $user = User::where('id','=',$user_id)->where('status','=',true)->first();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario logeado'
            ],404);
        }


        $user = $user->where('status','=',true)->first();

        if(!$user){
            return response()->json([
                'message' => 'No se encontro usuario o ha sido eliminado'
            ],404);
        }

        $address = $user->address()->where('id','=',$id)->first();

        if(!$address){  
            return response()->json([
                'message' => 'Lo sentimos, no se encontro dirección'
            ],404);
        }
        

        if($address->delete()){
            return response()->json([
                'message' => 'Dirección eliminada exitosamente'
            ],200);
        }else{
            return response()->json([
                'message' => 'Ha ocurrido un problema'
            ],404);
        }
    }
}
