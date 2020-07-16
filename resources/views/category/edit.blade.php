@extends('layout.app')

@section('title')

Editar categoria
    
@endsection



@section('content')

<h1 class="text-center my-5">Editar categoria</h1>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-default">

            <div class="card-header">Editar categoria</div>

            <div class="card-body">

                <!--Se haver algum erro no formulário-->
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

                <form action="{{route('category.update', ['id' => $category->id])}}" method="post">

                    @csrf

                    <div class="form-group">
                
                        <input type="text" class="form-control" placeholder="Categoria" name="categoria" 
                        value="{{$category->nome}}">
                
                    </div>

                    <div class="form-group">

                        <a href="{{route('category')}}" class="btn btn-primary my-2">Voltar</a>

                        <button type="submit" class="btn btn-success">Editar</button>

                    </div>
                
                </form>
            </div>

        </div>

    </div>

</div>

@endsection