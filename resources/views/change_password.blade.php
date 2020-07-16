@extends('layout.app')

@section('title')

Editar password
    
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

<h1 class="text-center my-5">Editar password</h1>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-default">

            <div class="card-header">Editar password</div>

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

                <form action="{{route('change_password.update')}}" method="post">

                    @csrf

                    <div class="form-group">

                        <label for="password"><b>Atual</b></label>
                    
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                
                    </div>

                    <div class="form-group">

                        <label for="n_password"><b>Nova</b></label>
                    
                        <input type="password" class="form-control" placeholder="Password" name="n_password" id="n_password">
                
                    </div>

                    <div class="form-group">

                        <label for="c_password"><b>Confirmar</b></label>
                    
                        <input type="password" class="form-control" placeholder="Password" name="c_password" id="c_password">
                
                    </div>


                    <div class="form-group">

                        <a href="{{route('profile')}}" class="btn btn-primary my-2">Voltar</a>

                        <button type="submit" class="btn btn-success">Editar password</button>

                    </div>
                
                </form>
            </div>

        </div>

    </div>

</div>

@endsection