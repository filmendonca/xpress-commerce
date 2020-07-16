@extends('layout.app')

@section('title')

Produtos
    
@endsection

@section('content')

@if (session()->has("qty"))
          
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{session()->get("qty")}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

    <h1 class="text-center my-5">LISTA DE PRODUTOS</h1>

    <form action="{{route('searchAttribute')}}" method="get" class="form-horizontal">
<div class="row">


<div class="col-lg-12">
    <div class="card card-filter">

    <div class="card-header d-flex flex-row justify-content-between py-2">
    <h5>Filtrar produtos</h5>
    <button type="reset" id="no-bd" onclick="uncheckAll()">Limpar</button>
    </div>

    <div class="row">

        <div class="card-body py-3 ml-3">
            <p class="fs-large">Categorias: </p>
            
            @foreach ($categories as $category)
            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                <input type="checkbox" name="categoria[]" class="custom-control-input" 
                id="customControlInline{{$category->id}}" value="{{$category->id}}"
                @for ($i = 0; $i < count($categories); $i++)
                <?php if(isset($_GET["categoria"][$i]) && $_GET["categoria"][$i] == $category->id){echo "checked";}?>
                @endfor> 
        
                <label class="custom-control-label" for="customControlInline{{$category->id}}">{{$category->nome}}</label>
                <br>
            </div>
            @endforeach
            
        </div>
        
            <div class="card-body py-3">
                <p class="fs-large">Classificação: </p>
        
        
                @for ($i = 0; $i < 5; $i++)
                    
                    <div class="custom-control custom-radio my-1 mr-sm-2">
                        <input type="radio" id="customRadio{{$i}}" name="class" value="{{$i}}" class="custom-control-input"
                        @if (request()->get('class') == $i && request()->get('class') != "")
                            checked
                        @endif>
                        <label class="custom-control-label" for="customRadio{{$i}}">
                        @if ($i == 0)
                            <span class="fa fa-star-o fa-lg text-warning"></span> (Não classificado)
                        @else
                            +@for ($j = 0; $j < $i; $j++)<span class="fa fa-star fa-lg text-warning"></span>@endfor
                        @endif</label>
                    </div>
                @endfor
        
            </div>
        
        
            <div class="card-body py-3">
            <p class="fs-large">Preço:</p>

                <input type="number" class="form-control col-lg-5 mb-3" name="preço[]" step="0.01" placeholder="Min" min="1" max="999999" value=
                <?php if(isset($_GET["preço"][0])){echo $_GET['preço'][0];}?>>


                <input type="number" class="form-control col-lg-5" name="preço[]" step="0.01" placeholder="Max" min="1" max="999999" value=
                <?php if(isset($_GET["preço"][1])){echo $_GET['preço'][1];}?>>
                
            </div>
        
            <div class="card-body py-3">
                <p class="fs-large">Disponível:</p>
        
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="disp" value="1" class="custom-control-input"
                    @if ((request()->get("disp") == 1)) checked @endif>
                    <label class="custom-control-label" for="customRadioInline1">Sim</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="disp" value="0" class="custom-control-input"
                    @if (request()->get("disp") == 0 && request()->get("disp") != "") checked @endif>
                    <label class="custom-control-label" for="customRadioInline2">Não</label>
                </div>
            </div>

    </div>




    <div class="card-footer py-3 d-flex justify-content-center">
        <input type="submit" class="btn btn-primary px-4 mt-2" value="Ordenar" name="order">
    </div>
    </div>
</form>
</div>







    <div class="row mt-3">
<!--
    <div class="col-sm-6 col-md-4">
    <div class="card card-product">
    <div class="card-header">
    <div class="btn btn-fab btn-sm" data-toggle-class="active" data-toggle="tooltip" data-placement="left" title="" data-original-title="Like it"><span class="icon-heart"></span></div>
    <div class="btn btn-fab btn-sm" data-toggle-class="active" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add to Cart"><span class="icon-shopping-cart"></span></div>
    <div class="btn btn-fab btn-sm" data-fancybox="" data-src="img/Cargo_Joggers_(1).jpg" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Image"><span class="icon-fullscreen fs-normal"></span></div>
    </div>
    <div class="card-body">
    <div class="img-place">
    <img src="img/Cargo_Joggers_(1).jpg" alt="">
    </div>
    <button class="btn btn-theme btn-rounded btn-sm btn-noanimate" data-toggle="modal" data-target="#modalProduct">Quick View</button>
    </div>
    <div class="card-footer">
    <div class="caption">
    <a href="product-details.html" class="product-title">Cargo Joggers</a>
    <p class="fg-theme">$19.99</p>
    </div>
    </div>
    </div>
    </div>
-->
    
        @forelse ($product as $prod)
        <div class="col-sm-6 col-md-4 mb-4">
        <div class="card-deck">
        <div class="card">
        <img class="card-img-top" src="{{asset('upload/imagem/'.$prod->imagem)}}" alt="Imagem">
          <div class="card-body">
            <h5 class="card-title"><b>{{$prod->nome}}</b>
                @if ($prod->disponivel == 0)
                <span class="badge badge-danger mx-2">Esgotado</span>
                @endif
            </h5>
            <?php
                echo "<p class='card-text'>". readMore($prod->descrição, 80)."</p>";
            ?>

                <b><h4 class="text-success my-4">
                    @php
                    $prod->preço = number_format($prod->preço,2,",",".");
                    @endphp
                    {{$prod->preço}} €</h4></b>
                

                    <?php
                        for($i=0; $i<5; ++$i){
                        echo '<i class="text-warning fa-lg fa fa-star',
                            ($prod->classificacao == $i +.5?'-half-full':''),
                            ($prod->classificacao == $i +.4?'-half-full':''),
                            ($prod->classificacao == $i +.6?'-half-full':''),
                            ($prod->classificacao == $i +.3?'-half-full':''),
                            ($prod->classificacao == $i +.7?'-half-full':''),
                            ($prod->classificacao == $i +.2?'-o':''),
                            ($prod->classificacao == $i +.1?'-o':''),
                            ($prod->classificacao <= $i ?'-o':''),
                            '" aria-hidden="true"></i>';
                        echo "\n";
                  }
                    ?>

            <p class="card-text my-4">
                <a href="{{route('products.show', ['product' => $prod->id])}}" 
                class="btn btn-primary btn-sm float-left">
                Ver
                </a>
                @if (auth()->check())
                @auth

                    @if (auth()->user()->id != $prod->id_user)
                        <a href="{{route('cart.menu.add', ['id' => $prod->id])}}"
                        class="btn btn-warning btn-sm float-left mx-2">
                            <i class="fa fa-shopping-basket"></i> Adicionar
                        </a>
                    @elseif(auth()->user()->id == $prod->id_user)
                        <span class="badge badge-info mx-2">Meu produto</span>
                    @endif
                    
                @endauth
                @endif
            </p>
          </div>
        </div>
    </div>
</div>
        @empty

        <div class="row justify-content-center">

            <div class="col-md-auto">
    
                <h3 class="text-center my-5">
                    <b>Não foram encontrados resultados</b>
                </h3>
    
            </div>
    
        </div>

        @endforelse



    </div>
    </div>
    

    </div>

    <div class="row justify-content-center">

        <div class="col-md-auto">

            <p class="text-center my-5">
                <!--Paginação juntamente com a palavra pesquisada-->
                {{$product->appends([
                "search" => request()->get("search"), 
                "order" => request()->get("order"),
                "class" => request()->get("class"),
                "disp" => request()->get("disp"),
                "preço" => request()->get("preço"),
                "categoria" => request()->get("categoria"),
                ])->links()}}
            </p>

        </div>

    </div>

@endsection

<?php
    // Função de ler mais
    function readMore($content, $limit) {
        $content = substr($content,0,$limit);
        $content = substr($content,0,strrpos($content,' '));
        $content .= "...";
        return $content;
    }
?>

<script>
    function uncheckAll(){
   $('input[type="radio"]:checked').attr('checked',false);
   $('input[type="checkbox"]:checked').attr('checked',false);
}
</script>