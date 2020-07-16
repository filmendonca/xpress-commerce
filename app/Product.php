<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Um produto só pode ter uma categoria
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    //Filtro para a pesquisa de produtos por atributos
    public function scopeFilter($query)
    {

        //dd(request()->all());

        if (request('categoria')) {
            for ($i=0; $i < count(request('categoria')); $i++) { 
                $query->orWhere('id_categoria', '=', request("categoria")[$i]);
            }
        }

        if (request('preço')[0] != null && request('preço')[1] != null) {
            $array = request('preço');
            for ($i=0; $i < 2; $i++) { 
                if($array[$i] <= 0 || $array[$i] > 999999){
                    $array[$i] = "1";
                }
            }
            $query->whereBetween('preço', [$array[0], $array[1]]);
            $query->orderBy('preço', 'ASC');
        }

        if (is_string(request('class'))) {  

            if(request('class') == 0){
                $query->where('classificacao', '=', request('class'));
            }
            else{
                $query->where('classificacao', '>=', request('class'));
            }
        }
        
        if (request('disp') != null && request('disp') == 0) {
            $query->where('disponivel', '=', 0);
        }

        elseif (request('disp') != null && request('disp') == 1) {
            $query->where('disponivel', '=', 1);
        }

        //dd(request('disp'));

        return $query;
    }
}
