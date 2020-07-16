@extends('layout.app')

@section('title')

Dashboard
    
@endsection

@section('content')

<h1 class="text-center my-5">Dashboard</h1>

<div class="row justify-content-center">

    <div class="col-md-5 well">
        <a href="{{route('category')}}" class="btn btn-primary btn-lg btn-block">Categorias</a>
        <a href="{{route('users')}}" class="btn btn-primary btn-lg btn-block">Utilizadores</a>
    </div>

</div>


        
@endsection