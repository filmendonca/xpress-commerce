<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Uma categoria pode ter vários produtos
    public function products()
    {
        //A categoria tem uma relação de "One to Many" para o produto
        return $this->hasMany('App\Product');
    }
}
