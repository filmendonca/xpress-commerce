@extends('layout.app')

@section('title')

Editar email
    
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

<h1 class="text-center my-5">Editar email</h1>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-default">

            <div class="card-header">Editar email</div>

            <div class="card-body">

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

                <form action="{{route('change_email.update')}}" method="post">

                    @csrf

                    <div class="form-group">

                        <label for="email"><b>Novo</b></label>
                    
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                
                    </div>


                    <div class="form-group">

                        <a href="{{route('profile')}}" class="btn btn-primary my-2">Voltar</a>

                        <button type="submit" class="btn btn-success">Editar email</button>

                    </div>
                
                </form>
            </div>

        </div>

    </div>

</div>

@endsection