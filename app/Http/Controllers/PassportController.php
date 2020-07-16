<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;

class PassportController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Por favor, llenar los campos correctamente',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::whereEmail($request->email)->first();
        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            $status = $user->status;

            if(!$status){
                return response()->json([
                    'message' => 'No se encontro usuario o ha sido eliminado'
                ],404);
            }

            $token = $user->createToken('')->accessToken;
            return response()->json(['success' => true, 'token' => $token],
            200);
        } else
            return response()->json(['res' => false, 'message' => "Usuario o contraseña incorrectos"],
            404);
    }

    public function logout(){
        $user = auth()->user();
        $user->tokens->each(function ($token, $key){
            $token->delete();
        });
        return response()->json(['res' => true, 'message' => "Hasta luego"],200);
    }

}
