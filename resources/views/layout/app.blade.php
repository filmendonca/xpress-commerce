<!--
Este ficheiro contém o que é comum a todas as outras views
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--Título para cada página-->
    <title>@yield('title')</title>

    <!--Ícone para o separador-->
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon">

    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/fonts.css')}}" rel="stylesheet">
    <link href="{{asset('/css/styles.css')}}" rel="stylesheet">

    <script src="{{asset('/js/jquery-3.2.1.slim.min.js')}}"></script>
    <script src="{{asset('/js/popper.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/main.js')}}"></script>

    <style>

      html, body {
        margin:0;
        padding:0;
        height:100%;
        overflow-x: hidden;
      }

      footer {
        position: relative;
        bottom:0;
        width:100%;
        height:60px;
        background:#6cf;
      }

      .container {
        min-height:100%;
        position:relative;
      }

      .bigHr {
    background-color: rgb(214, 214, 214);
    height: 1px;
    }

    .panel-default{
      border: 1px solid  #ddd;
      border-radius: 5px;
    }

    .carousel {
      background:#fff;
    }

    .carousel-item .img-fluid {
      width:100%;
      height:800px;
    }

    .carousel-item a {
      display: block;
      width:100%;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type=number] {
      -moz-appearance: textfield;
    }

    #no-bd{
      padding: 0;
      border: none;
      background: none;
      color: #0275d8;
    }

    #no-bd:hover{
      text-decoration-line: underline;
    }

    .parallax-section {
      padding: 0;
      width: 100%;
      height: 400px;
      margin-top: 20%;
      margin-bottom: 20%;
    }

    .parallax-section h1{
      color: white;
      padding-top: 15%;
    }

    .site-section {
      position: relative;
    }

    .bg-image-parallax {
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    .overlay-dark:before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(87, 80, 80, 0.705);
      z-index: 1;
    }

    .overlay-dark > .container {
      position: relative;
      z-index: 2;
    }

    </style>

</head>

<body>

    <div class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/~charlize"><img src="{{asset('/img/logo.png')}}" alt="Logo" width="90px" length="90px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('/') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('products')}}">Produtos <span class="sr-only">(current)</span></a>
                </li>
                <!--
                <li class="nav-item active">
                  <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link disabled" href="#">Disabled</a>
                </li>
                -->
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                          <a class="nav-link" href="{{route('add_product')}}">Adicionar produto <span class="sr-only">(current)</span></a>
                        </li>
                    @else
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                        @endif
                    @endauth
                @endif

              <form class="form-inline my-2 mx-5 my-lg-0" action="{{route('search')}}" method="GET">
              <input class="form-control mr-sm-2" type="search" name="search" placeholder="Pesquisar" 
              value="{{request()->get('search')}}" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
              </form>

            </ul>

            @if (auth()->check())
            @auth
                <ul class="nav-add">
                  <li class="cart">

                    <a href="{{route('cart')}}">
                      <i class="fa fa-lg fa-shopping-basket mr-5"></i>
                      <span class="cart-count">{{Cart::content()->count()}}</span>
                    </a>

                  </li>
                </ul>

                <img src="{{asset('/upload/avatar/'.auth()->user()->avatar)}}" 
                alt="Avatar" class="border border-primary rounded-circle ml-5" width="50px" height="50px">
                <div class="nav-item dropdown mx-1">
                    <a class="nav-link dropdown-toggle mr-5" href="#" id="navbarDropdown" 
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{auth()->user()->name}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('profile')}}">
                      <i class="fa fa-user mr-2"></i>Ver perfil</a>
                    @if (auth()->user()->admin())
                    <a class="dropdown-item" href="{{route('dashboard')}}">
                      <i class="fa fa-dashboard mr-1"></i>Dashboard</a> 
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                      <i class="fa fa-sign-out mr-2"></i>Sair</a>
                    </div>
              </div>
            @else
            @endauth
            @endif

            </div>
          </nav> 
    </div>
    
    <div class="container">

    <!--Se à sessão for passada uma mensagem de sucesso-->
      @if (session()->has("success"))
          
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session()->get("success")}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>

      @endif

      <!--Mensagem informativa-->
      @if (session()->has("info"))
          
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{session()->get("info")}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>

      @endif

        <!--Gera o conteúdo de cada view-->
        @yield('content')

    </div>

    
    <footer class="footer bg-secondary mt-5 ">

        <div class="text-center text-light py-3">
        © 2020 Copyright: Xpress Commerce
        </div>

    </footer>
    

</body>

</html>