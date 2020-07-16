<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Validator;
use DB;
use App\Product;

class CommentController extends Controller
{

    public function index()
    {

        //Vai buscar os comentários de um determinado 
        //$comment = DB::table('comments')->where("nome", "=", "");

        //Ordena os produtos por páginas
        //$product = Product::paginate(4);

        //Dentro do 'with', o nome do 1º parametro vai ser o mesmo
        //que na variável que vai ser usada na view do blade
        //return view('product')->with('comment', $comment);

    }
    
    //Adiciona o comentário na base de dados
    public function store(Request $request){

        if($request['flag'] && $request['flag'] == 1){
            $request['class'] = "0";
        }

        //Ver os dados do formulário
        //dd(request()->all());

        //Validação dos dados
        $validator = Validator::make($request->all(),[ 
        "titulo" => "required|min:3",
        "class" => "sometimes|integer|between:0,5",
        "texto" => "required|min:10|max:200",
        ]);

        if ($validator->fails()) { 
            session()->flash("comment-error", "Erro ao enviar comentário");
            return redirect("products/$request->id_produto")->withErrors($validator)->withInput(); 
        }
            
        $data = request()->all();

        if(!array_key_exists("class", $data)){
            $data["class"] = "0";
        }

        //dd($data);

        $comment = new Comment();

        $comment->titulo = $data["titulo"];
        $comment->id_user = $data["id_user"];
        $comment->id_produto = $data["id_produto"];
        $comment->texto = $data["texto"];
        $comment->classificacao = $data["class"];

        $comment->save();

        /*
        $avgClass = DB::select( DB::raw("SELECT avg(classificacao) AS avg
        FROM comments WHERE id_produto = :id"), array(
        'id' => $data["id_produto"],
        ));
        */

        $this->avgClassification($data["id_produto"]);

        session()->flash("comment", "Comentário criado com sucesso");

        return redirect("products/$request->id_produto");
    }

    public function edit($product, $commentId){

        $comment = Comment::find($commentId);

        return view("comment.edit", ['product' => $product, 'comment' => $comment]);

    }

    //Modifica o comentário
    public function update($productId, $commentId, Request $request){

        if($request['flag'] && $request['flag'] == 1){
            $request['class'] = "0";
        }

        //dd($productId);

        //Validação dos dados
        $validator = Validator::make($request->all(),[ 
            "titulo" => "required|min:3",
            "class" => "sometimes|integer|between:0,5",
            "texto" => "required|min:10|max:200",
        ]);

        if ($validator->fails()) { 
            return redirect("products/$productId/edit_comment/$commentId")->withErrors($validator)->withInput(); 
        }
            
        $data = request()->all();
        
        if(!array_key_exists("class", $data)){
            $data["class"] = "0";
        }

        $comment = Comment::find($commentId);

        $comment->titulo = $data["titulo"];
        $comment->texto = $data["texto"];
        $comment->classificacao = $data["class"];

        $comment->save();

        $this->avgClassification($productId);

        session()->flash("comment", "Comentário editado com sucesso");

        return redirect("products/$productId");
    }

    //Apaga o comentário
    public function delete($product, $commentId){

        $comment = Comment::find($commentId);

        $tempClass = $comment->classificacao;
        $idUser = $comment->id_user;

        if($tempClass > 0){
            
            //Arranja outro comentário escrito pela mesma pessoa
            $other = Comment::where('id_user', '=', $idUser)
            ->where('id', '<>', $commentId)
            ->where('classificacao', '=', 0)
            ->limit(1)
            ->get();
    
            //Passa a classificação do produto que vai ser apagado para outro produto
            foreach ($other as $val) {

                $val->classificacao = $tempClass;
                $val->save();

            };
        }

        $comment->delete();

        $this->avgClassification($product);

        session()->flash("success", "Comentário apagado com sucesso");

        return redirect("products/$product");

    }

    //Faz a média da classificação do produto
    private function avgClassification($product){

        $avgClass = DB::table('comments')
        ->where('id_produto', '=', $product)
        ->where('classificacao', '<>', 0.0)
        ->avg('classificacao');

        //dd($avgClass);

        $prod = Product::find($product);
        $prod->classificacao = 0;
        $prod->classificacao += $avgClass;

        $prod->save();

    }
    
}
