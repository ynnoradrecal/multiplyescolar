@extends('Loja::master')

@section('title', 'Dados do cliente - Visualizando Pedido')

@section('css')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.block-grid/latest/bootstrap3-block-grid.min.css">
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css">
	<style>
		#waterfall {
			overflow: hidden;
		}

		#waterfall.min {
			margin: 0;
		}

		#waterfall li {
			/*position: absolute;*/
			left: 0;
			top: 0;
			opacity: 0;
			z-index: 0;
			transform: translateY(100px);
		}

		#waterfall li:hover {
			z-index: 1;
		}

		#waterfall li.show {
			opacity: 1;
			transform: translateY(0);
			transition: all 0.3s, top 1s;
		}

		#waterfall li>div {
			color: rgba(0, 0, 0, 0.6);
			font-size: 32px;
			border-radius: 3px;
			margin: 5px;
			padding: 5px;
			background: rgb(255, 255, 255);
			/*border: 1px solid rgba(038, 191, 64, 0);*/
			transition: all 0.5s;
		}

		#waterfall li>div:hover {
			transform: translateY(-15px);
			/*border: 1px solid rgba(038, 191, 64, 1);*/
			/*box-shadow: 0 30px 80px rgba(038, 191, 64, 0.3);*/
			transition: all 0.3s;
		}

		#waterfall li.min > div {
			margin: 0;
			transform: none;
			border: none;
			border-radius: 0;
			box-shadow: none;
			/*border-bottom: 1px solid rgba(0, 0, 0, 0.1);*/
		}

		#waterfall li.min>div:hover {
			transform: none;
			border: none;
			border-radius: 0;
			box-shadow: none;
			/*border-bottom: 1px solid rgba(0, 0, 0, 0.1);*/
		}
	</style>
@endsection

@section('content')

	<section id="breadcrumb">
		
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines" />
		
		<div class="container">

			<div class="col-md-5">

				<h1>Dados do cliente</h1>

			</div>

			<div class="col-md-2 text-center">

					<i class="fa fa-folder-open" aria-hidden="true"></i>

			</div>

			<div class="col-md-5 text-right">

				<ul>
					<li>Home</li>
					<li>/</li>
					<li>Dados do cliente</li>
					<li>/</li>
					<li>Detalhe pedido</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">

	</section>

	<section id="clientes">

		<div class="container">

			<div class="row">

				<div class="col-md-4">
					{{--  Invoque Client LogedIn Sidebar   --}}
					@include('Loja::templates.sidebar-logedin')
				</div>

				<div class="col-md-8">
					
					@if( count($pedido) > 0)

						<div class="content-client-data detalhe-pedido">
							<h1>Pedido: <span>{{ $pedido[0]->num_pedido }}</span></h1>
							
							<div class="col-md-12">
								
								<div class="detalhe-container">
									
									<div class="header-box">
										
										<div class="row">
											<div class="col-md-6 ">
												<div class="info">
													<h3>Forma de Pagamento</h3>
													<strong>Cartão de crédito</strong>
													<h3>Referência</h3>
													<strong>{{ $pedido[0]->referencia }}</strong>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="price">
													<h3>Valor Frete</h3>
													<span>
														{{-- Sub Total: R$ {{ number_format($pedido[0]->total_parcial, 2, ',', '.') }}<br> --}}
														Frete: R$ {{ number_format($pedido[0]->valor_frete, 2, ',', '.') }}<br>
														<h3>Valor total do pedido</h3>
														R$ {{ number_format($pedido[0]->valor_pedido, 2, ',', '.') }}<br>
														
													</span>
												</div>
											</div>
										</div>
										<br>
										<div class="">
											<div class="col-md-12 itens">
												<br>
												<div class="row header"> 
													<div class="col-md-5">
														Produto
													</div>
													<div class="col-md-1 text-center">
														Qtd
													</div>
													<div class="col-md-3">
														Valor Unitário
													</div>
													<div class="col-md-2">
														Val. Parc.
													</div>
												</div>
												@for($i = 0; $i < count($pedido); $i++)
													<div class="row">
														<div class="col-md-5">
															{{ $pedido[$i]->titulo }}
														</div>
													
														<div class="col-md-1 text-center">
															{{ $pedido[$i]->quantidade }}
														</div>
														<div class="col-md-3">
															R$ {{  number_format($pedido[$i]->valor_unitario, 2, '.',',') }}
														</div>
														<div class="col-md-2">
															R$ {{ number_format(($pedido[$i]->valor_unitario * $pedido[$i]->quantidade),2,'.',',') }}
														</div>
													</div>
												@endfor
											</div>
										</div>
										<hr>
										
										<div class="row">
										
											<div class="col-md-12">
												<br>
												<div class="endereco">
													<h3>Endereço de entrega</h3>
													<span>
														{{-- <strong>{{ $pedido[0]->name }} {{ $pedido[0]->last_name }}</strong><br> --}}
														{{ $pedido[0]->logradouro }},
														{{ $pedido[0]->numero }} - {{ $pedido[0]->bairro }}<br>
														{{ $pedido[0]->cidade }} - {{ $pedido[0]->estado }}<br>
														{{ $pedido[0]->cep }}<br>
														
													</span>
												</div>
											</div>

										</div>
										
										<div class="clearfix"></div>
									</div>
									<br>
									<a href="#" id="fotos-pedido" idPedido="{{ $pedido[0]->pedido_id }}" class="btn btn-md btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg">Ver Fotos do Pedido</a>

								</div>

							</div>

							<div class="clearfix"></div>

						</div>
					@endif

				</div>

			</div>

		</div>

	</section>

	

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
		<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="gridSystemModalLabel">Fotos do Pedido: {{ $pedido[0]->referencia }}</h4>
      	</div>
		<div class="modal-body">
			<ul id="waterfall">
				@for($i=0; $i < count($fotos); $i++)			
					<li>
						<div>
							<div class="">
								<a href="{{ url('').$fotos[$i]->url }}" data-lightbox="gallery">
									<img src="{{ url('').$fotos[$i]->url }}" class="img-responsive" />
								</a>
							</div>
						</div>
					</li>
				@endfor
			</ul>
		</div>
    </div>
  </div>
</div>

@endsection

@section( 'scripts' )
	<script type="text/javascript" src="{{ asset('/js/newWaterfall.js')}}"></script>
	<script>
		$(document).ready(function(){

			lightbox.option({
				'resizeDuration': 100,
				'wrapAround': true,
				'alwaysShowNavOnTouchDevices': false
			})
			
			$('#waterfall').NewWaterfall({
				width: 270,
				delay: 100,
			});
		})
	</script>

@endsection