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
Auth::routes();
Route::resource('user-config', 'UsersController',['only' => ['index', 'destroy','update']]); /* Falta borrar el intento cuando no se tiene toda la user info  */
Route::resource('address', 'AddressController',['only' => ['index', 'store','show','update','destroy']]);
Route::post('/rols', 'RolController@store');

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


//Cosas relacionadas con productos
Route::resource('categories', 'CategoryController',['only' => ['index', 'store','show','update','destroy']]);
Route::resource('products', 'ProductController',['only' => ['index', 'store','show','update','destroy']]);


