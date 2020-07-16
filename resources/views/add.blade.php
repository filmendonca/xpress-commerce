@extends('layout.app')

@section('title')

Adicionar produto
    
@endsection



@section('content')

<h1 class="text-center my-5">Adicionar produto</h1>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-default">

            <div class="card-header">Adicionar produto</div>

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

                <form action="{{route('store_product')}}" method="post" enctype="multipart/form-data">

                    <!--Isto é um token que serve para prevenir o cross-site scripting.-->
                    <!--Ou seja, o formulário só é aceite se o pedido vier do próprio site.-->
                    @csrf

                <input type="hidden" name="id_user" value="{{auth()->user()->id}}">

                    <div class="form-group">

                        <label for="nome"><b>Nome</b></label>
                
                        <input type="text" class="form-control" placeholder="Nome" name="nome" 
                        value="{{old('nome')}}" id="nome">
                
                    </div>

                    <div class="form-group">

                        <label for="descricao"><b>Descrição</b></label>

                        <textarea name="descrição" placeholder="Descrição" id="descricao" cols="5" rows="5" class="form-control">{{old('descrição')}}</textarea>

                    </div>

                    <div class="form-group">

                        <label for="preco"><b>Preço</b></label>
                
                        <input type="number" step="0.01" min="0.01" class="form-control" 
                        placeholder="Preço" name="preço" value="{{old('preço')}}" id="preco">
                
                    </div>

                    <div class="form-group">

                        <label for="stock"><b>Stock</b></label>
                
                        <input type="number" min="1" class="form-control" placeholder="Stock" name="stock" 
                        value="{{old('stock')}}" id="stock">
                
                    </div>

                    <div class="form-group">

                        <label for="imagem"><b>Imagem</b></label>
                
                        <input type="file" class="form-control" name="imagem" 
                        value="" id="imagem">
                
                    </div>

                    <div class="form-group">
                        
                        <label for="category"><b>Categoria</b></label>

                        <select name="id_categoria" id="category" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->nome}}</option>
                            @endforeach
                        </select>
                
                    </div>

                    <div class="form-group">

                        <button type="submit" class="btn btn-success">Adicionar</button>

                    </div>
                
                </form>
            </div>

        </div>

    </div>

</div>

@endsection