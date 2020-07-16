@extends('layout.app')

@section('title')

Utilizadores
    
@endsection

@section('content')


<div class="row justify-content-center">

    <div class="col-md-auto">

        <h1 class="font-weight-normal my-5">Utilizadores:</h1>

    </div>

</div>

<!--Mensagem informativa-->
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <b>Nota: </b>Só os utilizadores verificados é que são obtidos pelo sistema.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Avatar</th>
      <th scope="col">Nome</th>
      <th scope="col">Email</th>
      <th scope="col">Admin</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>

  @foreach ($users as $user)

      <tr>
        <th scope="row" class="align-middle">{{$user->id}}</th>
        <td><img src="{{asset('upload/avatar/'.$user->avatar)}}" alt="" width="100px"></td>
        <td class="align-middle">{{$user->name}}</td>
        <td class="align-middle">
            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
        </td>
        <td class="align-middle">@if ($user->user_type == "admin")
            <span class="badge badge-primary mx-2">Sim</span>
          @else
            <span class="badge badge-secondary mx-2">Não</span>
            <a href="{{route('users.turn_admin', ['id' => $user->id])}}" class="btn btn-primary ml-5">Transformar em administrador</a>
        @endif</td>
        <td class="align-middle">
        </td>
      </tr>
  
  @endforeach

</tbody>
</table>

<div class="row justify-content-center">

  <div class="col-md-auto">

      <p class="text-center my-5">
        {{$users->links()}}
      </p>

  </div>

</div>
        
@endsection