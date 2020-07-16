@extends('layout.app')

@section('title')

Editar produto
    
@endsection



@section('content')

<h1 class="text-center my-5">Editar produto</h1>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-default">

            <div class="card-header">Editar produto</div>

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

                <form action="{{route('products.update_product', ['id' => $product->id])}}" method="post" enctype="multipart/form-data">

                    <!--Isto é um token que serve para prevenir o cross-site scripting.-->
                    <!--Ou seja, o formulário só é aceite se o pedido vier do próprio site.-->
                    @csrf

                    <div class="form-group">

                    <label for="nome"><b>Nome</b></label>
                
                    <input type="text" class="form-control" placeholder="Nome" name="nome" id="nome" 
                    value="@if(old('nome')){{old('nome')}}@else{{$product->nome}}@endif">
                
                    </div>

                    <div class="form-group">

                        <label for="descricao"><b>Descrição</b></label>

                        <textarea name="descrição" placeholder="Descrição" id="descricao" cols="5" rows="5" class="form-control">@if(old('descrição')){{old('descrição')}}@else{{$product->descrição}}@endif</textarea>

                    </div>

                    <div class="form-group">

                        <label for="preco"><b>Preço</b></label>
                
                        <input type="number" step="0.01" min="0.01" class="form-control" id="preco" placeholder="Preço" name="preço" 
                        value="@if(old('preço')){{old('preço')}}@else{{$product->preço}}@endif">
                
                    </div>

                    <div class="form-group">

                        <label for="stock"><b>Stock</b></label>
                
                        <input type="number" min="0" class="form-control" id="stock" placeholder="Stock" name="stock" 
                        value="@if(old('stock')){{old('stock')}}@else{{$product->stock}}@endif">
                
                    </div>

                    <div class="form-group">

                        <label for="imagem"><b>Imagem</b></label>
                
                        <input type="file" class="form-control" name="imagem" id="imagem">
                        <br>
                        Imagem atual:
                        <br>
                        <img src="{{asset('upload/imagem/'.$product->imagem)}}" alt="Imagem" class="img-fluid">
                
                    </div>

                    <div class="form-group">

                        <label for="category"><b>Categoria</b></label>
                
                        <select name="id_categoria" id="category" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}"
                                    @if ($product->id_categoria == $category->id)
                                        selected
                                    @endif
                                    >{{$category->nome}}</option>
                            @endforeach
                        </select>
                
                    </div>

                    <div class="form-group">

                    <a href="{{route('products.show', ['product' => $product->id])}}" class="btn btn-primary my-2">Voltar</a>

                        <button type="submit" class="btn btn-success">Editar produto</button>

                    </div>
                
                </form>
            </div>

        </div>

    </div>

</div>

@endsection