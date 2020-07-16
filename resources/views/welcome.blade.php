@extends('layout.app')

@section('title')

Home
    
@endsection

@section('content')

        <!--Login com sucesso-->
        @if (session()->has("log-success"))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session()->get("log-success")}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @endif

        <!--Logout com sucesso-->
        @if (session()->has("logout"))

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session()->get("logout")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        @endif  

    <div id="carousel-2" class="carousel slide carousel-fade my-5" data-ride="carousel" data-interval="6000">
      
      <ol class="carousel-indicators">
          <li data-target="#carousel-2" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-2" data-slide-to="1"></li>
          <li data-target="#carousel-2" data-slide-to="2"></li>
      </ol>

      <div class="carousel-inner" role="listbox">
        
          <div class="carousel-item active">
              <a href="{{route('products.show', ['product' => $products[0]->id])}}">
                <img src="{{asset('upload/imagem/'.$products[0]->imagem)}}" alt="imagem" class="d-block img-fluid">
              </a>
          </div>
        
          <div class="carousel-item">
              <a href="{{route('products.show', ['product' => $products[1]->id])}}">
               <img src="{{asset('upload/imagem/'.$products[1]->imagem)}}" alt="imagem" class="d-block img-fluid">
              </a>
          </div>
          
          <div class="carousel-item">
              <a href="{{route('products.show', ['product' => $products[2]->id])}}">
               <img src="{{asset('upload/imagem/'.$products[2]->imagem)}}" alt="imagem" class="d-block img-fluid">
              </a>
          </div>

      </div>
      
      <a class="carousel-control-prev" href="#carousel-2" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carousel-2" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>

        <div class="row justify-content-center">
            <div class="col-md-auto">
                <h1 class="text-center my-5">
                Bem-vindo
                </h1>
                <h5 class="text-center">No nosso site vai encontrar vários tipos de produtos que pode adquirir.</h5>
                <h5 class="text-center mt-3">Também pode colocar os seus produtos à venda de forma a que possam ser adquiridos por outros clientes.</h5>
            </div>
        </div>

        <div class="site-section parallax-section bg-image bg-image-parallax overlay-dark" style="background-image: url(img/eletrodomesticos.jpg)">
            <div class="container">
                <div class="d-block text-center fg-white">
                    <h1>Venha conhecer os nossos eletrodomésticos</h1>
                </div>
            </div>
        </div>
  
        <div class="row justify-content-center">
            <div class="col-md-auto">
                <h1 class="text-center my-5">
                Produtos adicionados recentemente
                </h1>
            </div>
        </div>

          <div class="row">
  
            @foreach ($others as $other)
                
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <img class="card-img-top" src="{{asset('upload/imagem/'.$other->imagem)}}" alt="">
                  <div class="card-body">
                    <h4 class="card-title">
                      <p><b>{{$other->nome}}</b></p>
                    </h4>
                    <h4 class="text-success">
                        @php
                        $other->preço = number_format($other->preço,2,",",".");
                        @endphp
                        {{$other->preço}} €</h4>
                  </div>
                  <div class="card-footer">
                    <?php
                        for($i=0; $i<5; ++$i){
                        echo '<i class="text-warning fa-lg fa fa-star',
                            ($other->classificacao == $i +.5?'-half-full':''),
                            ($other->classificacao == $i +.4?'-half-full':''),
                            ($other->classificacao == $i +.6?'-half-full':''),
                            ($other->classificacao == $i +.3?'-half-full':''),
                            ($other->classificacao == $i +.7?'-half-full':''),
                            ($other->classificacao == $i +.2?'-o':''),
                            ($other->classificacao == $i +.1?'-o':''),
                            ($other->classificacao <= $i ?'-o':''),
                            '" aria-hidden="true"></i>';
                        echo "\n";
                        }
                    ?>
                  </div>
                </div>
              </div>

            @endforeach

          </div>

        <div class="row justify-content-center">
            <div class="col-md-auto">
                <p class="text-center mt-5">
                  <a href="{{route('products')}}" class="btn btn-lg btn-primary">Ver mais produtos</a>
                </p>
            </div>
        </div>

@endsection