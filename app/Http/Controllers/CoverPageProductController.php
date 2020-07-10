<?php

namespace App\Http\Controllers;

use App\CoverPageProduct;
use Illuminate\Http\Request;

class CoverPageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $cov = [
            'product_id'=> $request->product_id,
            'image_id'=> $request->image_id,
        ];
        if(CoverPageProduct::create($cov)){
            return 200;
        }else{
            return 'Algo salió mal';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoverPageProduct  $coverPageProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CoverPageProduct $coverPageProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoverPageProduct  $coverPageProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CoverPageProduct $coverPageProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoverPageProduct  $coverPageProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoverPageProduct $coverPageProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoverPageProduct  $coverPageProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoverPageProduct $coverPageProduct)
    {
        //
    }
}
