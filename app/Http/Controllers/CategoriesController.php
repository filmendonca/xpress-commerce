<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Category;

class CategoriesController extends Controller
{

    //Certifica-se de que só quem for administrador é que pode modificar as categorias
    public function __construct(){

        $this->middleware('auth');

    }

    //Mostra todas as categorias
    public function index(){

        $category = Category::all();

        return view('category.index')->with('categories', $category);

    }

    public function add(){

        return view('category.add');

    }

    //Guarda uma categoria nova
    public function store(Request $request){

        //dd(request()->all());

        //Validação dos dados
        $validator = Validator::make($request->all(),[ 
            "categoria" => "required|string|min:3|max:40|unique:categories,nome",
        ]);

        if ($validator->fails()) { 
            return redirect("category/add")->withErrors($validator)->withInput(); 
        }
        
        $data = request()->all();

        $category = new Category();

        $category->nome = $data["categoria"]; 

        $category->save();

        session()->flash("cat-success", "Categoria criada com sucesso");

        return redirect("category");
    }

    public function edit($id){

        $category = Category::find($id);

        return view("category.edit")->with("category", $category);

    }

    public function update($id, Request $request){

        $validator = Validator::make($request->all(),[ 
            "categoria" => "required|string|min:3|max:40|unique:categories,nome",
        ]);

        if ($validator->fails()) { 
            return redirect("category/edit/{$id}")->withErrors($validator)->withInput(); 
        }

        $data = request()->all();

        $category = Category::find($id);

        $category->nome = $data["categoria"]; 

        $category->save();

        session()->flash("cat-success", "Categoria editada com sucesso");

        return redirect("category");

    }

    public function delete($id){

        $category = Category::find($id);

        $category->delete();

        session()->flash("cat-success", "Categoria apagada com sucesso");

        return redirect("category");

    }

}
