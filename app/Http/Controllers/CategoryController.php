<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
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

        $category = [
            'name' => $request->name,
        ];

        if(Category::create($category)){
            return response()->json([
                'message' => 'Categoria creada exitosamente',
                'category'=> $category
            ],200);
        }else{
            return response()->json([
                'message' => 'Ha ocurrido un problema'
            ],404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car= Category::find($id);
        return  $car;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
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
    
        $category =  Category::find($id);
        $category -> name = $request -> name;
        
        if($category->save()){
            return response()->json([
                'message' => 'Categoria actualizada exitosamente',
                'category'=> $category
            ],200);
        }else{
            return response()->json([
                'message' => 'Ha ocurrido un problema'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
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

        #Falta retornar excepciones
        if(Category::destroy($id)){
            return response()->json([
                'message' => 'Categoria eliminada exitosamente'
            ],200);
        }else{
            return response()->json([
                'message' => 'No se pudo eliminar la categoria'
            ],404);
        }
    }


    public function products_by_category($id){
       $category= Category::find($id);
        
        if(!$category){
            return response()->json([
                'message' => 'No se pudo encontrar la categoria'
            ],404);
        }

        return $category->products()->get();
    }


    public function prod_by_categories(){
        return Category::with('products')->get();
    }
}
