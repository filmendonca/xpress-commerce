<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;

use Validator;

use DB;

use Redirect;

class ProductController extends Controller
{

    public function index()
    {

        //Vai buscar todas as entradas
        //$product = Product::all();

        //Ordena os produtos por páginas, do mais recente para o mais antigo
        $product = Product::orderBy('created_at', 'DESC')->paginate(9);

        $category = Category::all();

        //Dentro do 'with', o nome do 1º parametro vai ser o mesmo
        //que na variável que vai ser usada na view do blade
        return view("product", ["product" => $product, 'categories' => $category]);

        /*

        $search = request()->query("search");

        if($search){
            //dd(request()->query("search"));
            $product = Product::where("nome", "LIKE", "%".$search."%")
            ->orWhere("descrição", "LIKE", "%".$search."%");
            //dd($product);
        }

        */

    }

    public function search(Request $request){

        //Pesquisa por texto

        $search = request()->get("search");

        $product = DB::table('products')->where("nome", "LIKE", "%".$search."%")
        ->orWhere("descrição", "LIKE", "%".$search."%")->paginate(9);

        $category = Category::all();

        return view("product", ["product" => $product, 'categories' => $category]);

    }

    public function searchAttribute(){

        //Pesquisa por atributos

        //dd(request()->all());

        //Utiliza o local scope definido no App\Product
        $product = Product::filter()->paginate(9);

        $category = Category::all();

        //dd($product);

        return view("product", ["product" => $product, 'categories' => $category]);

    }

    //o parametro vai ter o mesmo valor que o elemento da route {product}
    public function show($productId)
    {

        //Procura um produto que tenha o id pedido
        $product = Product::find($productId);

        //Vai buscar os comentários de um determinado produto
        $comment = DB::table('comments')
        ->select('comments.*', 'users.name', 'users.avatar', 'users.user_type')
        ->join('users', 'users.id', '=', 'comments.id_user')
        ->where("comments.id_produto", "=", "$productId")
        ->orderBy('created_at', 'DESC')
        ->paginate(5);

        //Vai buscar a categoria do produto
        $category = Category::find($product->id_categoria);

        //Retorna 3 produtos relacionados da mesma categoria que o produto a ser mostrado
        $other = Product::where('id', '<>', $productId)
        ->where('id_categoria', '=', $product->id_categoria)
        ->where('id_user', '<>', $product->id_user)
        ->inRandomOrder()
        ->limit(3)
        ->get();

        //dd($comment);

        return view('show', ['product' => $product,
        'comments' => $comment,
        'category' => $category,
        'others' => $other]);
    }

    //Retorna a página com o formulário para adicionar um produto
    public function add(){

        $category = Category::all();

        return view('add')->with('categories', $category);
        
    }

    //Coloca a informação enviada pelo formulário na base de dados
    public function store(Request $request){

        //Ver os dados do formulário
        //dd(request()->all());

        /*
        $value = $this->validate(request(), [
            "nome" => "required|min:3",
            "descrição" => "required|min:3",
            "preço" => "required",
        ]);
        */

        //Validação dos dados
        $validator = Validator::make($request->all(),[ 
            "nome" => "required|string|min:3|max:40",
            "descrição" => "required|string|min:3|max:350",
            "preço" => "required|numeric|between:0.01,999999.99",
            "stock" => "required|integer|between:1,999999",
            "imagem" => "required|image|mimes:jpeg,png,jpg|max:2048|dimensions:min_width=100,min_height=200",
            "id_categoria" => "required",
        ]);

        if ($validator->fails()) { 
            return redirect("add_product")->withErrors($validator)->withInput(); 
        }

        $imagem = $request->imagem;
        //Timestamp para o nome da imagem
        $imagemNome = time()."_".$imagem->getClientOriginalName();
        $imagem->move("upload/imagem", $imagemNome);
            
        $data = request()->all();

        $product = new Product();

        $product->nome = $data["nome"];
        $product->id_user = $data["id_user"];
        $product->descrição = $data["descrição"];
        $product->preço = $data["preço"];
        $product->stock = $data["stock"];
        $product->imagem = $imagemNome;
        $product->id_categoria = $data["id_categoria"];

        //Faz uma query para a base de dados
        $product->save();

        session()->flash("success", "Produto criado com sucesso");

        //Redireciona o utilizador
        return redirect("products");
    }

    public function edit($productId){

        $category = Category::all();

        $product = Product::find($productId);

        return view("edit")->with(['product' => $product, 'categories' => $category]);

    }

    public function update($productId, Request $request){

        //dd($request);

        $validator = Validator::make($request->all(),[
            "nome" => "required|string|min:3|max:40",
            "descrição" => "required|string|min:3|max:350",
            "preço" => "required|numeric|between:0.01,999999.99",
            "stock" => "required|integer|between:0,999999",
            "imagem" => "sometimes|image|mimes:jpeg,png,jpg|max:2048|dimensions:min_width=100,min_height=200",
            "id_categoria" => "required",
        ]);

        if ($validator->fails()) { 
            return redirect("products/$productId/edit")->withErrors($validator)->withInput(); 
            //return redirect()->back()->withInput()->withErrors($validator); 
        }

        //dd(request()->all());

        $data = request()->all();

        $product = Product::find($productId);

        //Caso tenha sido feito o upload de uma imagem nova
        if($request->imagem){
            if ($product->imagem != "prod_default.jpg") {
                if(file_exists("upload/imagem/".$product->imagem)){
                    unlink("upload/imagem/".$product->imagem);
                }
            }
            $imagem = $request->imagem;
            $imagemNome = time()."_".$imagem->getClientOriginalName();
            $imagem->move("upload/imagem", $imagemNome);
            $product->imagem = $imagemNome;
        }

        $product->nome = $data["nome"];
        $product->descrição = $data["descrição"];
        $product->preço = $data["preço"];
        $product->stock = $data["stock"];
        $product->id_categoria = $data["id_categoria"];

        if($product->stock > 0){
            $product->disponivel = 1;
        }
        elseif($product->stock == 0){
            $product->disponivel = 0;
        }

        $product->save();

        session()->flash("success", "Produto editado com sucesso");

        return redirect("products/$productId");

    }

    public function delete($productId){

        $product = Product::find($productId);

        if ($product->imagem != "prod_default.jpg") {
            //Apaga a imagem dos uploads
            if(file_exists("upload/imagem/".$product->imagem)){
                unlink("upload/imagem/".$product->imagem);
            }
        }

        //Apaga os comentários do produto
        $comment = DB::table('comments')
        ->where('id_produto', '=', $productId)
        ->delete();

        //Apaga o produto da base de dados
        $product->delete();

        session()->flash("success", "Produto apagado com sucesso");

        return redirect("products");

    }
}
