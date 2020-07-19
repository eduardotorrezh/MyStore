<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
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

        $product = [
            'name' => $request->name,
            'price' => $request->price,
            'discount' => $request->discount,
            'final_price' => $request->final_price,
            'stock' => $request->stock,
            'description' => $request->description,
            'size' => $request->size,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
        ];
        if(Product::create($product)){
            return 200;
        }else{
            return 'algo salió mal';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug_id)
    {
        $product = Product::where('slug','=', $slug_id)->orWhere('id', '=', $slug_id)->first();

        if(!$product){  
            return response()->json([
                'message' => 'Lo sentimos, no se encontro el producto'
            ],404);
        }
        return  $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

        $product =  Product::find($id);

        if(!$product){
            return response()->json([
                'message' => 'Lo sentimos, no se encontro el producto'
            ],404);
        }

        $product -> name = $request -> name;
        $product -> price = $request -> price;
        $product -> discount = $request -> discount;
        $product -> final_price = $request -> final_price;
        $product -> stock = $request -> stock;
        $product -> description = $request -> description;
        $product -> size = $request -> size;
        $product -> slug = $request -> slug;
        $product -> category_id = $request -> category_id;
        if($product->save()){
            return 200;
        }else{
            return 'Algo salió mal';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

        Product::destroy($id);
        return 'Borrado';
    }
}
