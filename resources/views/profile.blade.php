@extends('layout.app')

@section('title')

Perfil
    
@endsection

@section('content')

@if (session()->has("fail"))
         
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{session()->get("fail")}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

    <div class="row mt-5">
      <div class="col-lg-5 col-md-6">
        <div class="mb-2">
          <img class="w-100" src="{{asset('upload/avatar/'.auth()->user()->avatar)}}" alt="">
        </div>
        <div class="mb-2 d-flex">
        </div>
        <div class="mb-2">
        </div>
      </div>


      <div class="col-lg-7 col-md-6 pl-xl-3">
        <h1 class="font-weight-normal text-center">{{auth()->user()->name}}</h1>

        <h5 class="font-weight-normal my-4">Dados pessoais</h5>

        <ul class="list-unstyled">
            <li class="media">
              <span class="w-25 text-black font-weight-normal"><b>Email:</b></span>
              <label class="media-body">{{auth()->user()->email}}    <a href="{{route('change_email')}}">Alterar email</a></label>
            </li>
            <li class="media">
              <span class="w-25 text-black font-weight-normal"><b>Data de registo:</b></span>
              <label class="media-body">

                @php
                //Formatação da data e da hora
                $explode =  explode(" ", auth()->user()->created_at);
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
              @endphp
                
              </label>
            </li>
            <li class="media">
                <a href="{{route('change_password')}}">Alterar palavra-passe</a>
            </li>
        </ul>


        <a href="{{route('profile.edit')}}" 
        class="btn btn-primary mt-3">Editar nome e avatar</a>

        
      </div>
    </div>






    <div class="row justify-content-center">

        <div class="col-md-auto">

            <h1 class="font-weight-normal my-5">Produtos à venda:</h1>



        </div>

    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Imagem</th>
          <th scope="col">Nome</th>
          <th scope="col">Esgotado</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>

      @forelse ($products as $product)

          <tr>
            <th scope="row" class="align-middle">{{$product->id}}</th>
            <td><img src="{{asset('upload/imagem/'.$product->imagem)}}" alt="" width="100px"></td>
            <td class="align-middle">{{$product->nome}}</td>
            <td class="align-middle">@if ($product->stock == 0)
                <span class="badge badge-danger mx-2">Sim</span>
              @else
                <span class="badge badge-success mx-2">Não</span>
            @endif</td>
            <td class="align-middle">
              <a href="{{route('products.show', ['product' => $product->id])}}">
                <button class="btn btn-primary float-left">Ver</button>
              </a>
            </td>
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


    
@endsection
