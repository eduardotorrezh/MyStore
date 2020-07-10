<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','price','discount','final_price','stock','description','size','category_id','slug'
    ];


    public function images()
    {
        return $this->belongsToMany('App\Image','images');
    }

    public function imagesCount()
    {
        return $this->images()->count();
    }
}
