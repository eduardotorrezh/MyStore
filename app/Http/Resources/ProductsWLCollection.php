<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Category;
class ProductsWLCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($element){
                $cat = Category::find($element->category_id);
                
                return [
                    'id' => $element->id,
                    'name' => $element->name,
                    'price' => "$".($element->price),
                    "discount" => $element->discount,
                    "final_price" => $element->final_price,
                    "description" => $element->description,
                    "size" => $element->size,
                    "slug" => $element->slug,
                    "category_id" => $cat->name ,
                ];  
            })
        ];
        
    }

    
    
    public function encrypt($Algo){
        return "hola";
    }



}
