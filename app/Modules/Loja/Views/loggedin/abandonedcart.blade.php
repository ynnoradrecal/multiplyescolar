@extends('Loja::master')

@section('title', 'Dados do cliente - Carrinho Abandonado')

@section('css')
	<style type="text/css" media="screen">
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
					<li>Atendimento</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">
	</section>

	<section id="clientes">
		<div class="container">
			<div class="col-md-4">
				@include('Loja::templates.sidebar-logedin')
			</div>
			<div class="col-md-8 col-xs-12 clearfix">
				<div class="content-client-data">
					<h1>Compras não Concluidas</h1>
					<br>
					@foreach( $data as $item )
					<div class="col-md-6 col-sm-6 col-xs-12 grids" ref="{{ $item->id }}">

						<div class="list-endereco text-center">
							
							<figure>
								<img src="{{ url('') }}/uploads/repositorio/{{ $item->produto_id }}/thumb_small/{{ $item->thumb }}" alt="..." class="img-circle">
							</figure>
							
							<br/>

							<div class="header-box">
								<p class="nome">{{ $item->nome }}</p>
							</div>

							<div class="footer-box">

								<div class="btn-group" role="group" aria-label="">
									<button class="btn btn-azul btn-sm continuar">Continuar</button>
									<button class="btn btn-danger btn-sm exc-cart-story">Excluir</button>
								</div>

							</div>

						</div>
					</div>
					@endforeach
				</div>
			</div>
			<div class="col-md-8 col-xs-12 text-center cart-store-clean" style="padding: 100px 0px 160px;display:none;">

				<h1>SEU HISTÓRICO DE COMPRAS NÃO CONCLUIDAS, ESTA VAZIO!</h1>
				<p>Clique no botão a baixo, para navegar na galeria de eventos</p>
				<a href="{{ url('') }}/eventos" class="btn btn-default">
					<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> EVENTOS
				</a>

			</div>
		</div>

	</section>

@endsection

@section('scripts')
	<script>
		$(function() {

			var $body = $('.content-client-data');

			if($('.content-client-data > .grids').size() == 0) {
				$body.find('h1').hide();
				$('.cart-store-clean').show();
			}

			$('.exc-cart-story').on('click', function() {

				var $grid = $(this).parents('.grids');

				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});

				$.ajax({
					url: '/escolar/del-cart-abandonado',
					type: 'post',
					dataType: 'json',
					data: {
						'id': $grid.attr('ref')
					},
					success: function( res ) {
						if(res.status == 'success') {
							
							$grid.fadeOut(400, function(){
								$(this).remove();
								if($('.content-client-data > .grids').size() == 0) {

									$body.find('h1').hide();
									$('.cart-store-clean').show();

									$('#recupera-carrinho').hide();

								}
							});
							

						}
					}
				});

			})

			$('.continuar').on('click', function(event) {
				event.preventDefault();
				
				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});

				$.ajax({
					url: '/escolar/recuperar-cart',
					type: 'post',
					dataType: 'json',
					data: {
						'id': $(this).parents('.grids').attr('ref')
					},
					success: function( res ) {
						if(res.status == 'success') {
							location.href = res.redirect
						}
					}
				});

			})

		})
	</script>
@endsection