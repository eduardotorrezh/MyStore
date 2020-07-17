<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

//Cosas referentes al usuario
Auth::routes(['login'=>false,'logout'=>false]); //Register
Route::post('login', 'PassportController@login');

//TOKENS PASSPORT
Route::group(['middleware'=>'auth:api'], function(){
    #Usuarios
    Route::get('auth_user','UsersController@auth_user');
    Route::post('logout', 'PassportController@logout'); //elimina todos los tokens

    #Direcciones
    Route::ApiResource('address', 'AddressController');
    
});

Route::resource('user-config', 'UsersController',['only' => ['index', 'destroy','update']]); /* Falta borrar el intento cuando no se tiene toda la user info  */
#Route::resource('address', 'AddressController',['only' => ['index', 'store','show','update','destroy']]);
Route::post('/rols', 'RolController@store');
#Route::get('auth_user','UsersController@auth_user');
#Route::post('login','UsersController@login');
#Route::post('logout','UsersController@logout');
Route::post('user-inf','UsersController@show');

//Cosas referentes a la WL
Route::post('add-to-wl','ProductsInWishListController@store');
Route::delete('del-to-wl','ProductsInWishListController@destroy');
Route::post('wl-products','WishListController@show');
/* Falta hacer la validación de que no pueda agregarse el mismo producto a la WL */ 

//Cosas referentes a la SC
Route::post('add-to-sc','ProductsInShoppingCartController@store');
Route::delete('del-to-sc','ProductsInShoppingCartController@destroy');
Route::put('upt-to-sc','ProductsInShoppingCartController@update');
Route::post('prods-of-sc','ShoppingCartController@show');
Route::post('pay-sc','ShoppingCartController@pay_sc');


//Cosas relacionadas con productos
Route::resource('categories', 'CategoryController',['only' => ['index', 'store','show','update','destroy']]);
Route::resource('products', 'ProductController',['only' => ['index', 'store','show','update','destroy']]);


//BuyAndSells
Route::get("all-payments","BuyAndSellController@index");