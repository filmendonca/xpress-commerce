@extends('layout.app')

@section('title')

Carrinho
    
@endsection

@section('content')

@if (session()->has("item"))
          
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session()->get("item")}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

@if (session()->has("carts"))
          
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{session()->get("carts")}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

@if (session()->has("qty"))
          
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{session()->get("qty")}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

<div class="container-fluid">
    <div class="row bg-border-color medium-padding120">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">

                        <h1 class="cart-title mt-5">Itens no carrinho: {{Cart::content()->count()}} produtos</h1>

                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">Remover</th>
                                    <th scope="col">Imagem</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Preço</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                          
                                @forelse (Cart::content() as $product)
                          
                                    <tr>
                                        <td class="align-middle"><a href="{{route('cart.delete', ['id' => $product->rowId])}}" title="Remover item">
                                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </a>
                                        </td> 
                                      <td>
                                        <a href="{{route('products.show', ['product' => $product->id])}}">
                                            <img src="{{asset('upload/imagem/'.$product->model->imagem)}}" width="100px" alt="product" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                        </a>
                                      </td>
                                      <td class="align-middle">{{$product->name}}</td>
                                      <td class="align-middle">{{$product->price}} €</td>
                                      <td class="align-middle">
                                        <form action="{{route('cart.update', ['id' => $product->rowId])}}" method="get">
                                          <input title="Qty" name="qty" class="form-control" value="{{$product->qty}}" type="number">
                                          <span class="btn btn-primary inc button fa fa-plus"></span>
                                          <span class="btn btn-primary dec button fa fa-minus"></span>
                                          <button type="submit" class="btn btn-sm btn-success my-2">Atualizar</button>
                                        </form>
                                      </td>
                                      <td class="align-middle">{{$product->total()}}</td>
                                    </tr>
                          
                                @empty
                          
                                    <tr>
                                      <th scope="row" class="align-middle"></th>
                                      <td></td>
                                      <td class="align-middle">
                                        Não tem produtos à venda
                                      </td>
                                      <td></td>
                                    </tr>
                                
                                @endforelse
                          
                              </tbody>
                            </table>

                    <div class="cart-total">
                        <h5 class="cart-total-total mt-5">Total do carrinho: 
                            <span class="text-danger">
                              {{Cart::total()}} €</span>
                        </h5>
                        @if (Cart::total() == 0) 
                            <button class="btn btn-secondary" disabled data-toggle="tooltip" title="Não tem nenhum produto no carrinho.">Checkout</button>
                        @else
                        <a href="{{route('cart.checkout')}}" class="btn btn-primary">
                            Checkout
                        </a>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });

    $(".button").on("click", function() {

var $button = $(this);
var oldValue = $button.parent().find("input").val();

if ($button.attr('class') == 'btn btn-primary inc button fa fa-plus') {
  var newVal = parseFloat(oldValue) + 1;
} else {
 // Don't allow decrementing below zero
  if (oldValue > 1) {
    var newVal = parseFloat(oldValue) - 1;
  } else {
    newVal = 1;
  }
}

$button.parent().find("input").val(newVal);

});
</script>

@endsection