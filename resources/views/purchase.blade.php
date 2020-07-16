<h3>Olá {{auth()->user()->name}},</h3>
<br>
Informamos que adquiriu os seguintes produtos: 
<br><br>

@for ($i = 0; $i < count($produtos['nome']); $i++)

    <b>Nome: </b>{{$produtos["nome"][$i]}}
    <br>
    <b>Quantidade: </b>{{$produtos["qty"][$i]}}
    <br>
    <b>Total: </b>{{$produtos["total"][$i]}} €
    <br><br>
    
@endfor

<br>
<b>Total de todos os produtos: </b>{{$produtos["totalAll"]}} €
<br><br><br>

Os nossos cumprimentos,
<br>
<br>
<h2>Xpress Commerce</h2>