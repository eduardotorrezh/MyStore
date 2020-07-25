<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\InfoUser;
use App\WishList;
use App\ShoppingCart;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $email = openssl_decrypt($data['email'], 'AES-256-CBC', "xxxSecretKey1xxxxxxSecretKey1xxx");
        try{
            Mail::send('emails',['data' => $data],function($message) use ($email){
                $message->from('mystorebusiness9@gmail.com','My Store');
                $message->to($email)->subject('Aviso de Bienvenida');
            });
        }catch(Exception $ex){
            return response()->json([
                'message' => 'No se pudo realizar el envio'
            ],404);
        }

        $user=[
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'rol_id' => $data['rol_id'],
            'password' => $data['password'],
        ];
        if($us=User::create($user) ){
            $user_info=[
                'user_id' => $us->id,
                'birthday' => $data['birthday'],
                'genre' => $data['genre'],
                'phone' => $data['phone'],
            ];
            if($iu = InfoUser::create($user_info)){
                $sc = ['user_id' => $us->id,'status' => true ];
                $wl = [ 'user_id' => $us->id ];
                if(WishList::create($wl) && ShoppingCart::create($sc)){
                    return [
                        'user'=> $us,
                        'info' => $iu,
                        'wl'=> $sc,
                        'sc'=>$wl
                    ];
                }
            }else{
                User::destroy($us->id);
            }
        }

    }
}
