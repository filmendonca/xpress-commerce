<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Product;
use Mail;

class ShoppingController extends Controller
{

    //Só quem estiver autenticado e verificado é que pode aceder e manipular o carrinho
    public function __construct(){

        $this->middleware('verified');

    }

    //Mostra a página do carrinho de compras
    public function index(){
        return view('cart');
    }

    //Adiciona um item ao carrinho
    public function add($id, Request $request){

        //dd(Cart::content());

        foreach (Cart::content() as $item) {
            if($item->id == $id){
                
                $product = Product::find($item->id);

                //Se o stock do produto for inferior à quantidade no carrinho mais a quantidade pedida
                if($product->stock < $item->qty + request()->qty){
                    session()->flash("qty", "A quantidade no carrinho é maior do que o stock existente");
                    return redirect("products/$id");
                }

                else{

                    $cartItem = Cart::add([
                        'id' => $product->id,
                        'name' => $product->nome,
                        'qty' => $request->qty,
                        'price' => $product->preço
                    ]);
            
                    Cart::associate($cartItem->rowId, 'App\Product');
                    return redirect('cart');

                }

            }

        }

        $product = Product::find($id);

        //Adiciona um novo item ao carrinho ou atualiza a quantidade de um item já existente
        $cartItem = Cart::add([
            'id' => $product->id,
            'name' => $product->nome,
            'qty' => $request->qty,
            'price' => $product->preço
        ]);

        //Associa o item do carrinho com um determinado rowId com o modelo do Produto
        Cart::associate($cartItem->rowId, 'App\Product');

        //Array de itens no carrinho
        //dd(Cart::content());

        //Conteúdo de um item do carrinho
        //dd($cartItem);

        return redirect('cart');

    }

    //Atualiza a quantidade de itens do produto no carrinho
    public function updateQty($id){

        //Nota: $id representa o rowId do carrinho

        //dd(Cart::content()[$id]);

        //Obtem o id do produto que está no carrinho e que vai ser modificado
        $product = Product::where('id', '=', Cart::content()[$id]->id)
        ->get();

        //dd($product[0]);

        //Caso a quantidade pedida seja maior do que o stock
        if($product[0]->stock < request()->qty){
            session()->flash("qty", "A quantidade no carrinho é maior do que o stock existente");
            return redirect('cart');
        }

        else{
            Cart::update($id, request()->qty);
            return redirect('cart');
        }

    }

    //Adiciona um item ao carrinho a partir do menu de produtos
    public function menuAdd($id){

        $product = Product::find($id);

        if($product->stock == 0){
            session()->flash("qty", "A quantidade no carrinho é maior do que o stock existente");
            return redirect('products');
        }
        
        foreach (Cart::content() as $item) {

            //Caso a quantidade pedida seja maior do que o stock
            if($item->qty >= $product->stock){
                
                session()->flash("qty", "A quantidade no carrinho é maior do que o stock existente");
                return redirect('products');
            }

        }

        $cartItem = Cart::add([
            'id' => $product->id,
            'name' => $product->nome,
            'qty' => 1,
            'price' => $product->preço
        ]);

        Cart::associate($cartItem->rowId, 'App\Product');

        return redirect('products');

    }

    //Remove o item do carrinho
    public function delete($id){

        Cart::remove($id);

        session()->flash("item", "Item removido do carrinho com sucesso");

        return redirect('cart');

    }

    public function checkout(){

        if(Cart::total() == 0){

            session()->flash("carts", "Não tem nenhum produto no carrinho para ser adquirido");

            return redirect('cart');

        }

        else{

            foreach (Cart::content() as $item) {
                $product = Product::find($item->id);
                
                if($product->stock < request()->qty){
                    session()->flash("qty", "A quantidade no carrinho é maior do que o stock existente");
                    return redirect('cart');
                }
            }

            return view('checkout');
        }

    }

    public function purchase(Request $request){

        //dd(request()->total);

        request()->total = str_replace(",", "", request()->total);

        $obj = new \stdClass();  
        $obj->email = auth()->user()->email;

        $obj->totalAll = 0;

        for ($i=0; $i < count(request('nome')); $i++) { 
            $obj->totalAll += request()->total[$i];
        }

        $data = [
            'email' => $obj->email,
            'content' => '', 
            'nome' => request()->nome,
            'qty' => request()->qty,
            'total' => request()->total,
            'totalAll' => $obj->totalAll,
        ];

        //dd($data);

        //Enviar um email
        Mail::send("purchase", ["produtos"=>$data], function ($message) use ($obj){
            $message->from('fil40320@gmail.com', 'ecommerceApp');
            $message->to($obj->email)
                    ->subject('Compra de produtos');
        });

        //Caso haja erro ao enviar email
        if(count(Mail::failures()) > 0){
            session()->flash("fail", "Erro ao efetuar pagamento");
            return redirect('cart/checkout');
        }

        else{

            //Retirar a quantidade comprada ao stock de cada produto
            for ($i=0; $i < count(request('id')); $i++) { 
                
                $product[] = Product::find(request()->id[$i]);

                $product[$i]->stock -= request()->qty[$i];

                //Caso o stock se torne zero
                if($product[$i]->stock == 0){
                    $product[$i]->disponivel = 0;
                }

                $product[$i]->save();

            }

            //Remove todos os itens do carrinho
            Cart::destroy();

            session()->flash("success", "Pagamento efetuado com sucesso");
            return redirect('products');
        }

    }

}
