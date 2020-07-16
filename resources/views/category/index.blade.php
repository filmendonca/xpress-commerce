@extends('layout.app')

@section('title')

Categorias
    
@endsection

@section('content')

@if (session()->has("cat-success"))
         
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session()->get("cat-success")}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

<h1 class="text-center my-5">Categorias</h1>

<div class="panel panel-default mt-5">

    <div class="panel-body">

        <table class="table table-hover">
            <thead>
                <th>
                    Nome
                </th>
                <th>
                    Editar
                </th>
                <th>
                    Apagar
                </th>
            </thead>
        
            <tbody>
                @forelse ($categories as $category)


                    
                    <tr>
                        <td>
                            {{$category->nome}}
                        </td>
                        <td>
                            <a href="{{route('category.edit', ['id' => $category->id])}}" 
                            class="btn btn-info btn-sm my-2"><i class="fa fa-pencil"></i></a>
                        </td>
                        <td>
                            <button data-toggle="modal" data-target="#modal{{$category->id}}"
                            class="btn btn-danger btn-sm my-2"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>

                    <div class="modal" id="modal{{$category->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content ">
                          
                            <div class="modal-header">
                              <h4 class="modal-title">Apagar categoria</h4>
                              <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            
                            <div class="modal-body">
                              Tem a certeza que deseja apagar esta categoria?
                            </div>
                            
                            <div class="modal-footer">
                                <a href="{{route('category.delete', ['id' => $category->id])}}" class="btn btn-danger my-2">Sim</a>
                                <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal">Não</button>
                            </div>
                            
                          </div>
                        </div>
                      </div>

                @empty
        
                <tr>
                    <td>
                        Ainda não há categorias
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

<a href="{{route('category.add')}}" class="btn btn-success my-2">Adicionar categoria nova</a>

@endsection