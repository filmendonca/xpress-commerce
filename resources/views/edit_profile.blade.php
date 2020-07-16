@extends('layout.app')

@section('title')

Editar dados pessoais
    
@endsection



@section('content')

<h1 class="text-center my-5">Editar dados</h1>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-default">

            <div class="card-header">Editar dados</div>

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

                <form action="{{route('profile.update', ['id' => auth()->user()->id])}}" method="post" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="{{auth()->user()->id}}">

                    <div class="form-group">

                        <label for="nome"><b>Nome</b></label>
                    
                        <input type="text" class="form-control" placeholder="Nome" name="name" id="nome"
                        @if (old())
                            value="{{old('name')}}"
                        @else
                            value="{{auth()->user()->name}}"
                        @endif
                        required>
                
                    </div>

                    <div class="form-group">

                        <label for="avatar"><b>Avatar</b></label>
                
                        <input type="file" class="form-control" name="avatar">
                        Avatar atual:
                        <br>
                        <img src="{{asset('/upload/avatar/'.auth()->user()->avatar)}}" alt="Avatar" class="img-fluid">
                
                    </div>

                    <div class="form-group">

                        <a href="{{route('profile')}}" class="btn btn-primary my-2">Voltar</a>

                        <button type="submit" class="btn btn-success">Editar dados</button>

                    </div>
                
                </form>
            </div>

        </div>

    </div>

</div>

@endsection