<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

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
    public function show($slug)
    {
        $product = Product::where('slug','=', $slug)->get();
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
        $product =  Product::find($id);
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
        Product::destroy($id);
        return 'Borrado';
    }
}
