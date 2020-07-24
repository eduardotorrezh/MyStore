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
Auth::routes(['login'=>false,'logout'=>false,'verify' => true]); //Register and verified emails
Route::post('login', 'PassportController@login');

 //Send Emails
 Route::get('password_recovery','UsersController@password_recovery');



//TOKENS PASSPORT
Route::group(['middleware'=>'auth:api'], function(){
    #Usuarios
    Route::get('auth_user','UsersController@auth_user');
    Route::post('logout', 'PassportController@logout'); //elimina todos los tokens
    Route::resource('user-config', 'UsersController',['only' => ['index', 'destroy','update']]); /* Falta borrar el intento cuando no se tiene toda la user info  */
    Route::post('change-password','UsersController@changePassword');
    Route::get('user-inf','UsersController@show');

    #Direcciones
    Route::ApiResource('address', 'AddressController');

    #Categorias
    Route::ApiResource('categories', 'CategoryController',['only' => ['store','update','destroy']]);
  

    #Productos
    Route::ApiResource('products', 'ProductController',['only' => ['store','update','destroy']]);
   
    //Cosas referentes a la WL
    /* Falta hacer la validación de que no pueda agregarse el mismo producto a la WL */ 
    Route::post('add-to-wl','ProductsInWishListController@store');
    Route::delete('del-to-wl','ProductsInWishListController@destroy');
    Route::get('wl-products','WishListController@show');

    //Cosas referentes a la SC
    Route::post('add-to-sc','ProductsInShoppingCartController@store');
    Route::delete('del-to-sc','ProductsInShoppingCartController@destroy');
    Route::put('upt-to-sc','ProductsInShoppingCartController@update');
    Route::get('prods-of-sc','ShoppingCartController@show');

    //Cosas referentes a la SC
    Route::post('pay-sc','ShoppingCartController@pay_sc');

    //BuyAndSells
    Route::get("all-payments","BuyAndSellController@index");   
    Route::get("products_by_cars/{id}","BuyAndSellController@products_by_cars");
    Route::post("user-payments","BuyAndSellController@byUserCurr");
});



#Categorias GET
Route::ApiResource('categories', 'CategoryController',['only' => ['index', 'show']]);
Route::get("prod_by_category/{id}","CategoryController@products_by_category");
Route::get("prod_by_categories","CategoryController@prod_by_categories");
#Productos GET
Route::ApiResource('products', 'ProductController',['only' => ['index','show']]);

//BuyAndSells
//Route::get("all-payments","BuyAndSellController@index");
//Route::post("user-payments","BuyAndSellController@byUser");
