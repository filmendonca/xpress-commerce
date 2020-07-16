@extends('layout.app')

@section('title')

Editar comentário
    
@endsection



@section('content')

<h1 class="text-center my-5">Editar comentário</h1>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-default">

            <div class="card-header">Editar comentário</div>

            <div class="card-body">

                <!--Se houver algum erro no formulário-->
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

                <form action="{{route('comments.update', ['id' => $product, 'commentId' => $comment->id])}}" method="post">

                    @csrf

                    <div class="form-group">

                        <label for="titulo"><b>Título</b></label>
                    
                        <input type="text" class="form-control" placeholder="Título" id="titulo" name="titulo" 
                        value="@if(old('titulo')){{old('titulo')}}@else{{$comment->titulo}}@endif">
                
                    </div>

                    <div class="form-group">

                        <label for="texto"><b>Texto</b></label>

                        <textarea name="texto" placeholder="Texto" id="texto" cols="5" rows="5" class="form-control">@if(old('texto')){{old('texto')}}@else{{$comment->texto}}@endif</textarea>

                    </div>

                    <div class="form-group col-md-3">

                        <label for="classificacao"><b>Classificação</b></label>

                        <h4 id="output"></h4>
                
                        @if ($comment->classificacao > 0)
                            
                            <script>
                                var star = 1;
                                makeStar(star);
                                function makeStar(star){
                                    var str = "";
                                    for(var j=1;j<=star;j++){
                                    str +=  '<input type="hidden" name="class" value='+j+'><span onmouseover="makeStar('+j+')" class="fa fa-star text-warning ml-1"></span>';
                                    }
                                    for(var k=star+1;k<=5;k++){
                                    str +=  '<input type="hidden"><span onmouseover="makeStar('+k+')" class="fa fa-star-o text-warning ml-1"></span>';
                                    }  
                                    document.querySelector("#output").innerHTML = str;
                                }
                            </script>

                        @else

                            <script>
                                makeStar();
                                function makeStar(){
                                var str = '<div data-toggle="tooltip" data-placement="top" title="Já classificou este produto."><input type="hidden" name="class" value='+j+'><span class="fa fa-star text-secondary ml-1"></span>';
                                for(var j=1; j<=4; j++){
                                    str +=  '<input type="hidden" name="class" value='+j+'><span onmouseover="" class="fa fa-star-o text-secondary ml-1"></span>';
                                }
                                str += '</div><input type="hidden" name="flag" value="1">';
                                document.querySelector("#output").innerHTML = str;
                                }
                            </script>

                        @endif
                
                        <!--
                        <select class="form-control" name="class" id="classificacao"
                        @if ($comment->classificacao == 0)
                            disabled data-toggle="tooltip" title="Já atribuiu uma classificação a este produto."
                        @else
                            value="{{$comment->classificacao}}"
                        @endif>
                            @for ($i = 1; $i <= 5; $i++)
                                <option @if ($i == $comment->classificacao)
                                    selected
                                @endif>{{$i}}</option>
                            @endfor
                        </select>
                    -->
                    </div>

                    <div class="form-group">

                    <a href="{{route('products.show', ['product' => $product])}}" class="btn btn-primary my-2">Voltar</a>

                        <button type="submit" class="btn btn-success">Editar comentário</button>

                    </div>
                
                </form>
            </div>

        </div>

    </div>

</div>

    <!--Tooltip da classificação-->
    <script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>

@endsection