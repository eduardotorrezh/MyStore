<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\InfoUser;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->orderBy('id')->get(); //->paginate(7); if you want the pagination functionality
        return $users;
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $user = User::where('status','=',true)->where('id','=',$id)->first();

        // if(!$user){
        //     return response()->json([
        //         'message' => 'No se encontro usuario o ha sido eliminado'
        //     ],404);
        // }

        // return response()->json([
        //     $user
        // ],200);

    }

    public function auth_user(){
        $user = Auth::user();

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

        return response()->json([
            $user
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'last_name' => $request->last_name,
        ]);
            // Post::where('slug','=', $slug)->firstOrFail();
        $asd = [
            'birthday' => $request->birthday,
            'genre' => $request->genre,
            'phone' => $request->phone 
        ];
        $ius = InfoUser::where('user_id','=', $id)->update($asd);
        $ius = InfoUser::where('user_id','=', $id)->get();
        

        return [
            'us'=>$user,
            'if'=>$ius
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asd = [
            'status' => false,
        ];
        $user = User::where('id','=', $id)->update($asd);
        $user = User::where('id','=', $id)->get();
        // $user = User::findOrFail($id);
        // $user->update([
        //     'status' => false,
        // ]);

        return $user;
    }
}
