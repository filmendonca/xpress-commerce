@extends('layout.app')

@section('title')

Carrinho
    
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

		<div class="row">

				<div class="col-lg-12">
			<div class="order">
				<h2 class="h1 order-title text-center mt-5">A sua compra</h2>

					<table class="table">
						<thead>
						  <tr>
							<th scope="col">Produto</th>
							<th scope="col">Quantidade</th>
							<th scope="col">Total</th>
						  </tr>
						</thead>
						<tbody>

							@php
								$totalQty = 0
							@endphp
				  
						@forelse (Cart::content() as $product)
				  
							<tr>
							  <td class="align-middle">{{$product->name}}</td>
							  <td class="align-middle">x {{$product->qty}}</td>
							  <td class="align-middle">{{$product->total()}} €</td>
							</tr>

							@php
								$totalQty += $product->qty
							@endphp
				  
						@empty
				  
							<tr>
							  <th scope="row" class="align-middle"></th>
							  <td></td>
							  <td class="align-middle">
								Não tem produtos à venda
							  </td>
							  <td></td>
							</tr>
						
						@endforelse

						<tr class="bg-success">
							<th scope="row" class="align-middle text-white">Total</th>
							<td class="align-middle text-white"><b>{{$totalQty}}</b></td>
							<td class="align-middle text-white"><b>{{Cart::total()}} €</b></td>
						</tr>
				  
					  </tbody>
					</table>

			</div>


				<div class="row ml-1">

					<img src="{{asset('img/payment.png')}}" alt="pagamento" width="220px">
	
				</div>
				
				<div class="row d-flex justify-content-center mt-5">

					<form action="{{route('cart.checkout')}}" method="post">
	
						@csrf

						@foreach (Cart::content() as $product)

							<input type="hidden" name="id[]" value="{{$product->id}}">
							<input type="hidden" name="nome[]" value="{{$product->name}}">
							<input type="hidden" name="qty[]" value="{{$product->qty}}">
							<input type="hidden" name="total[]" value="{{$product->total()}}">
							
						@endforeach
				
						<button type="submit" class="btn btn-primary">Pagar</button>
	
					</form>
	
				</div>

		</div>

	</div>


@endsection