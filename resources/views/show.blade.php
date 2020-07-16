@extends('layout.app')

@section('title')

{{$product->nome}}
    
@endsection

@section('content')

@if (session()->has("comment"))
         
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session()->get("comment")}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

@if (session()->has("comment-error"))
         
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{session()->get("comment-error")}}
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

<h1 class="text-center my-5">{{$product->nome}}</h1>



    <div class="container dark-grey-text mt-5">

      <div class="row mb-5">

        <div class="col-md-6 mb-4">

            <div class="view">

                <div class="mask flex-center rgba-green-strong">
                    <img src="{{asset('upload/imagem/'.$product->imagem)}}" class="img-fluid" alt="">
                </div>
            </div>
          

        </div>
        
        <div class="col-md-6 mb-4">

          <div class="p-4">

            <p class="lead">
              <h3 class="text-warning"><b>
                @php
                $product->preço = number_format($product->preço,2,",",".");
                @endphp
                {{$product->preço}} €</b></h3>
            </p>

            <p class="lead font-weight-bold">Descrição</p>

            <p>{{$product->descrição}}</p>

            <p class="lead font-weight-bold">Stock</p>

            <p>@if($product->disponivel == 0)
              <h5><span class="badge badge-danger my-2">Esgotado</span></h5>
            @else
              {{$product->stock}}
            @endif</p>

            <?php

                  for($i=0; $i<5; ++$i){
                      echo '<i class="text-warning fa-lg fa fa-star',
                          ($product->classificacao == $i +.5?'-half-full':''),
                          ($product->classificacao == $i +.4?'-half-full':''),
                          ($product->classificacao == $i +.6?'-half-full':''),
                          ($product->classificacao == $i +.3?'-half-full':''),
                          ($product->classificacao == $i +.7?'-half-full':''),
                          ($product->classificacao == $i +.2?'-o':''),
                          ($product->classificacao == $i +.1?'-o':''),
                          ($product->classificacao <= $i ?'-o':''),
                          '" aria-hidden="true"></i>';
                      echo "\n";
                  }
              
            ?>

            @if ($product->classificacao == 0)
                (Não classificado)
              @else
              @php
              $product->classificacao = number_format($product->classificacao,1,",", "0");
              @endphp
              ({{$product->classificacao}})
            @endif 

            <p class="text-secondary font-weight-bold text-uppercase mt-4">{{$category->nome}}</p>

            @if (auth()->check())
            @auth
                @if (auth()->user()->id == $product->id_user)

                    <h5><span class="badge badge-info my-2">Meu produto</span></h5>
    
                    <a href="{{route('products.edit', ['product' => $product->id])}}" class="btn btn-info my-2">Editar</a>
    
                    <button data-toggle="modal" data-target="#modal"
                    class="btn btn-danger my-2">Apagar</button>
                
                @elseif(auth()->user()->id != $product->id_user)
    
                  <form action="{{route('cart.add', ['id' => $product->id])}}" method="get">

                    @if ($product->disponivel == 0)
                    <div data-toggle="tooltip" data-placement="top" title="Este produto está esgotado">
                      <input type="number" min="1" max="{{$product->stock}}" class="form-control mb-3" name="qty" disabled title="Qty">
                      <button disabled class="btn btn-lg btn-secondary fa fa-minus"></button>  
                      <button disabled class="btn btn-lg btn-secondary fa fa-plus"></button>
                        <button disabled type="submit" class="btn btn-secondary">
                          <i class="fa fa-shopping-cart"></i> Adicionar
                        </button>
                    </div>

                    @else
                      <input type="number" value="1" min="1" max="{{$product->stock}}" class="form-control mb-3" name="qty" title="Qty">
                      <span class="btn btn-lg btn-primary inc button fa fa-plus"></span>
                      <span class="btn btn-lg btn-primary dec button fa fa-minus"></span>  
                        <button type="submit" class="btn btn-primary">
                          <i class="fa fa-shopping-cart"></i> Adicionar
                        </button>
                    @endif
                  
        
                  </form>
    
                @endif
            @endauth
            @endif

          </div>

        </div>

      </div>

      <hr>

      <div class="row d-flex justify-content-center wow fadeIn">

        <div class="col-md-7 text-center">

          <h4 class="my-4 h4">Outros produtos que podem ser do seu interesse:</h4>

        </div>

      </div>

      <div class="row">

        @forelse ($others as $other)

          <div class="col-lg-4 col-md-12 mb-4">

            <img src="{{asset('upload/imagem/'.$other->imagem)}}" class="img-fluid" alt="Imagem">
            
            <h5 class="my-3"><b>{{$other->nome}}</b></h5>

            <h3 class="text-success">
              @php
              $other->preço = number_format($other->preço,2,",",".");
              @endphp
              {{$other->preço}} €</h3>

            <a href="{{route('products.show', ['product' => $other->id])}}" class="btn btn-primary btn-sm mt-3">
            Ver</a>

          </div>
            
        @empty

          <p>Não foi encontrado nenhum produto relacionado</p>
            
        @endforelse

      </div>

    </div>

<br><br>

<hr class="bigHr">

<h1 class="text-center mb-5">Comentários</h1>

@if ($errors->any())
                    
<div class="alert alert-danger">

    <ul class="list-group">

        @foreach ($errors->all() as $error)
            <li class="list-group-item">
                {{$error}}
            </li>
        @endforeach

    </ul>

</div>

@endif

@auth

<form action="{{route('comments.add', ['id' => $product->id])}}" method="post">
    @csrf

    <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
    <input type="hidden" name="id_produto" value="{{$product->id}}">

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" 
            value="@if(old('titulo')){{old('titulo')}}@endif">
        </div>


    
        <div class="form-group col-md-2 pl-5">
            <label for="class">Classificação</label>

            <h4 id="output"></h4>
                
            <script>
              var star = 1;
              makeStar(star);
              function makeStar(star){
                var str = "";
                for(var j=1;j<=star;j++){
                  str +=  '<input type="hidden" name="class" value='+j+'><span onmouseover="makeStar('+j+')" class="fa fa-star text-warning ml-1"></span>';
                }
                for(var k=star+1;k<=5;k++){
                str +=  '<input type="hidden"><span onmouseover="makeStar('+k+')" class="fa fa-star-o text-warning ml-1"></span>';
                }  
                document.querySelector("#output").innerHTML = str;
              }
            </script>
            
        </div>
    </div>

    <div class="form-group">
      <label for="texto">Texto</label>
      <textarea class="form-control" id="texto" rows="3" name="texto">@if(old('texto')){{old('texto')}}@endif</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>

@endauth

<br><br><br><br>

        @forelse ($comments as $comment)

        <div class="container">
            <div class="row">
                <div class="col-2">
                    <span class="d-block">
                        <img src="{{asset('/upload/avatar/'.$comment->avatar)}}" 
                        alt="Avatar" class="border rounded" width="100px" height="100px">
                    </span>
                    @if ($comment->user_type == "admin")
                      <span class="d-block ml-2 mt-2 text-primary" title="Administrador"><b>{{$comment->name}}</b></span>
                    @else
                      <span class="d-block ml-2 mt-2 text-secondary" title="Utilizador normal"><b>{{$comment->name}}</b></span>
                    @endif
                </div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            {{$comment->titulo}}
                        </div>
                        <div class="card-body">

                          <p class="card-text">
                            {{$comment->texto}}
                          </p>
                          @if ($comment->classificacao != 0)
                              <h5 class="card-text">
                                @for ($i = 0; $i < $comment->classificacao; $i++)
                                  <span class="fa fa-star text-warning"></span>
                                @endfor
                                @php $empty = 5 - $comment->classificacao @endphp
                                @for ($i = 0; $i < $empty; $i++)
                                  <span class="fa fa-star-o text-warning"></span>
                                @endfor
                              </h5>
                          @endif
                            <p class="card-text"><small class="text-muted">
                              @php
                                //Formatação da data e da hora
                                $explode =  explode(" ", $comment->created_at);
                                $expData = explode("-", $explode[0]);
                                $ano = $expData[0];
                                $mes = $expData[1];
                                $dia = $expData[2];
                                $expHora = explode(":", $explode[1]);
                                $hora = $expHora[0];
                                $minuto = $expHora[1];

                                $meses = array(
                                '01' => "janeiro",
                                '02' => "fevereiro",
                                '03' => "março",
                                '04' => "abril",
                                '05' => "maio",
                                '06' => "junho",
                                '07' => "julho",
                                '08' => "agosto",
                                '09' => "setembro",
                                '10' => "outubro",
                                '11' => "novembro",
                                '12' => "dezembro");

                                foreach ($meses as $key => $value) {
                                    if($mes == $key){
                                        $mes = $value;
                                    }
                                }

                                echo $dia. " de " .$mes. " de " .$ano. " às " .$hora. ":". $minuto; 
                            @endphp</small>
                            
                            @if ($comment->created_at != $comment->updated_at)
                                <small class="text-muted ml-5">
                                  @php
                                    $explode =  explode(" ", $comment->updated_at);
                                    $expData = explode("-", $explode[0]);
                                    $ano = $expData[0];
                                    $mes = $expData[1];
                                    $dia = $expData[2];
                                    $expHora = explode(":", $explode[1]);
                                    $hora = $expHora[0];
                                    $minuto = $expHora[1];
    
                                    $meses = array(
                                    '01' => "janeiro",
                                    '02' => "fevereiro",
                                    '03' => "março",
                                    '04' => "abril",
                                    '05' => "maio",
                                    '06' => "junho",
                                    '07' => "julho",
                                    '08' => "agosto",
                                    '09' => "setembro",
                                    '10' => "outubro",
                                    '11' => "novembro",
                                    '12' => "dezembro");
    
                                    foreach ($meses as $key => $value) {
                                        if($mes == $key){
                                            $mes = $value;
                                        }
                                    }
                                
                                    echo "*Última vez editado: ". $dia. " de " .$mes. " de " .$ano. " às " .$hora. ":". $minuto; 
                                    @endphp</small> 

                            @endif
                            
                            </p>
                 
                            @if (auth()->check() && auth()->user()->id == $comment->id_user)

                                <a href="{{route('comments.edit', ['id' => $product->id, 'commentId' => $comment->id])}}" 
                                class="btn btn-info btn-sm my-2">Editar</a>

                                <button data-toggle="modal" data-target="#modalComment{{$comment->id}}"
                                class="btn btn-danger btn-sm my-2">Apagar</button>

                                <!--Pop-up para apagar comentário-->
                                <div class="modal" id="modalComment{{$comment->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                          <h4 class="modal-title">Apagar comentário</h4>
                                          <button type="button" class="close" data-dismiss="modal">×</button>
                                        </div>
                                        
                                        <div class="modal-body">
                                          Tem a certeza que deseja apagar o comentário?
                                        </div>
                                        
                                        <div class="modal-footer">
                                          <a href="{{route('comments.delete', ['id' => $product->id, 'commentId' => $comment->id])}}" type="button" class="btn btn-danger">Sim</a>
                                          <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal">Não</button>
                                        </div>
                                        
                                    </div>
                                    </div>
                                </div>

                                <!--Se o utilizador já tiver classificado o produto antes, não pode voltar a classificá-lo-->
                                <script>
                                  makeStar();
                                  function makeStar(){
                                    var str = '<div data-toggle="tooltip" data-placement="top" title="Já classificou este produto."><input type="hidden" name="class" value='+j+'><span class="fa fa-star text-secondary ml-1"></span>';
                                    for(var j=1; j<=4; j++){
                                      str +=  '<input type="hidden" name="class" value='+j+'><span onmouseover="" class="fa fa-star-o text-secondary ml-1"></span>';
                                    }
                                    str += '</div><input type="hidden" name="flag" value="1">';
                                    document.querySelector("#output").innerHTML = str;
                                  }
                                </script>

                            @endif

                        </div>
                      </div>
                </div>
            </div>
        </div>

        <br><br><br><br>
            
        @empty

        <h4 class="text-center my-5">
            Este produto ainda não tem comentários.
        </h4>
            
        @endforelse

        <span class="text-center my-5">
            {{$comments->links()}}
        </span>

    <!--Tooltip-->
    <script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>

    <!--Pop-up para apagar produto-->
  <div class="modal" id="modal">
    <div class="modal-dialog model-dialog-centered">
      <div class="modal-content ">
      
        <div class="modal-header">
          <h4 class="modal-title">Apagar produto</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <div class="modal-body">
          Tem a certeza que deseja apagar o produto?
        </div>
        
        <div class="modal-footer">
          <a href="{{route('products.delete', ['product' => $product->id])}}" type="button" class="btn btn-danger">Sim</a>
          <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal">Não</button>
        </div>
        
      </div>
    </div>
  </div>

<script>
  $(".button").on("click", function() {

var $button = $(this);
var oldValue = $button.parent().find("input").val();

if ($button.attr('class') == 'btn btn-lg btn-primary inc button fa fa-plus') {
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
