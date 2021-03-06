<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class PassportController extends Controller
{
    use AuthenticatesUsers;
    public $maxAttempts=3;
    public $decayMinutes=2;

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ]);
        
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            Log::alert('Se ha alcanzado el límite de intentos máximos que son: '.$this->maxAttempts.' por parte de: '.$request->email);

            $this->fireLockoutEvent($request);

            return response()->json([
                'Se ha rebasado el número de intentos' => $this->maxAttempts(),
                'Intento actual' => $this->limiter()->hit($this->throttleKey($request)),
                'Tiempo de espera para próximo intento' => $this->decayMinutes().' minutos',
                'Intentando accesar desde el correo' => $request->email,
            ],429);
        }

        if ($validator->fails()) {
            $this->incrementLoginAttempts($request);
            Log::channel('single')->info('Datos incorrectos por parte de: '.$request->email);

            return response()->json([
                'message' => 'Por favor, llenar los campos correctamente',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::whereEmail($request->email)->first();

        
        if (!is_null($user) && $request->password == $user->password) {
            $status = $user->status;

            if(!$status){
                Log::channel('single')->info('No se ha encontrado el usuario '.$request->email);

                return response()->json([
                    'message' => 'No se encontro usuario o ha sido eliminado'
                ],404);
            }

            $token = $user->createToken('users')->accessToken;
            Log::channel('single')->info('Ha iniciado sesión con éxito '.$request->email);

            return response()->json(['success' => true, 'token' => $token],
            200);
        } else
            Log::channel('single')->info('Datos incorrectos por parte de '.$request->email);
            $this->incrementLoginAttempts($request);

            return response()->json(['res' => false, 'message' => "Usuario o contraseña incorrectos"],
            404);
    }

    public function logout(){
        $user = auth()->user();
        $user->tokens->each(function ($token, $key){
            $token->delete();
        });
        Log::channel('single')->info('Usuario '.$user->email. ' cerro sesión');
        return response()->json(['res' => true, 'message' => "Hasta luego"],200);
    }

}
