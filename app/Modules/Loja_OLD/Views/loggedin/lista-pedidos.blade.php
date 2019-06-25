@extends('Loja::master')

@section('title', 'Dados do cliente - Lista de Pedidos')

@section('css')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.block-grid/latest/bootstrap3-block-grid.min.css">
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
					<li>Lista de pedidos</li>
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

					<div class="content-client-data">
						@if( session("referencia"))
							<div class="alert alert-danger">
								Houve um erro com o pedido <strong>{{ session("referencia") }}</strong> por favor contate já o atendimento.
							</div>
						@endif
						
						<h1>Meus Pedidos</h1>
						
						
						@for ($i = 0; $i < count($pedidos); $i++)
						
						<div class="row">
							<div class="col-md-12">
								
								<div class="list-pedido">
									
									<div class="header-box">
										<div class="row">
											{{-- <div class="col-md-3">
												<img src="{{ asset('/')}}images/4.jpg" class="img-responsive" />
											</div> --}}
											
											<div class="col-md-3 ">
												<div class="dates">
													<h4>Realizado em:</h4>
													<p><span>{{ date('d/m/Y', strtotime( $pedidos[$i]->created_at ) ) }}</span></p>

													{{-- <p><strong>Status Pagamento</strong>
													{{ statusPagamento($pedidos[$i]->status) }}</p> --}}
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="status-entrega">
													<?php $date = Carbon\Carbon::parse($pedidos[$i]->created_at)->addDays($pedidos[$i]->prazo_entrega); ?>
													
													@if ( $date->format('Ymd') < date('Ymd') )
														
														<h3>Produto Entregue</h3>
													
													@else 
														<h3>Status de Entrega</h3>
														<p>Entrega prevista para:</p>
														{{ $date->format('d/m/Y') }}
														
													@endif
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="info">
													<h3>Código do Pedido</h3>
													<span>{{ $pedidos[$i]->num_pedido }}</span>
													<br>
													<h3>Valor total</h3>
													<span>R$ {{ number_format($pedidos[$i]->valor_pedido, 2, ',', '.') }}</span>
												</div>
											</div>
										</div>
										
										<div class="clearfix"></div>
									</div>

									<div class="footer-box">
										<div class="show-pedido text-right">
											<a href="{{ url('/minha-conta/'.$pedidos[$i]->cliente_id.'/pedido/'.$pedidos[$i]->id.'/'.$pedidos[$i]->num_pedido)}}" class="btn btn-blue btn-lg">
												Ver Detalhes
											</a>
										</div>
									</div>

								</div>

							</div>
						</div>

						@endfor

						<div class="clearfix"></div>

					</div>

				</div>

			</div>

		</div>

	</section>

@endsection
