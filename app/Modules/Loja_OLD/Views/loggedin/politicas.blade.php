@extends('Loja::master')

@section('title', 'Lista de Alunos')

@section('css')
	
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css" />
	<link rel="stylesheet" href="{{ asset("css") }}/slick-theme.css" />
	<style>

		.container-radio .radio{
			width: 20px;
			height: 20px;
			background: #ccc !important;
			border: solid 2px #f02;
		}

		.container-radio{
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.container-radio li{
			display: inline-block;
		}

		.container-radio li label{
			font-size: 22px;
			margin-left: 12px;
		}

		.slick-dots li button::before{
			font-size: 40px !important;
		}

	</style>

@endsection

   
@section('content')

	<section id="breadcrumb">

		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">

		<div class="container">

			<div class="col-md-5">

				<h1>Opções</h1>

			</div>

			<div class="col-md-2 text-center">
				<i class="fa fa-th" aria-hidden="true"></i>
			</div>

			<div class="col-md-5 text-right">

				<ul>
					<li>Home</li>
					<li>/</li>
					<li>Repositórios</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">

	</section>


	<section id="breadcrumb-compra">

		<div class="container">

			<ul>
				<div class="col-md-6 col-sm-6 col-xs-10 col-xs-offset-1 col-md-offset-0">
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Eventos 
					</li>
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Galerias 
					</li>
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Galeria 
					</li>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-10 col-xs-offset-1 col-md-offset-0">
					<li class="active"><span>4</span> Opções </li>
					<li><span>5</span> Entrega </li>
					<li><span>6</span> Pagamento </li>
				</div>
			</ul>

		</div>

	</section>

	<section id="politicas">

		<div class="container">
			
			<form action="{{ url('/') }}/add-to-cart/options" method="post">

				{{-- <input name="_token" type="hidden" value="{{ Session::token() }}"> --}}
				{{ csrf_field() }}

				<?php $i = $j = 0; ?>

				{{-- {{ dd($politicas) }} --}}

				@foreach ( $politicas as $politica )
					<div class="box-container">
					<h2 class="text-center"> {{ $politica->nome }} </h2>
					<?php $products = collect(json_decode($politica->list)); ?>

					{{-- {{ dd($products) }} --}}
					
					@foreach ($products->chunk(4) as $chunk)
						<div class="row">
							@foreach ($chunk as $product)

								@if( $product->price != '')
								<div class="col-sm-3">
									<div class="box-politica">
										<h3 class="">{{ $product->title }}</h3>

										@if ( count($product->images) > 0 )
											<div class="slik-itens">
												@foreach( $product->images as $image)
													{{-- <div class="slik-item"> --}}
														<a href="{{ url($product->path.'/'.$image->image) }}" data-lightbox="gallery{{ $i }}">
															<img src="{{ url($product->path.'/'.$image->image) }}" class="img-responsive" />
														</a>
													{{-- </div> --}}
												@endforeach
											</div>
											<input type="hidden" name="politicas[{{ $j }}][imagem]" value="{{ url($product->path.'/'.$product->images[0]->image) }}"/>

										@endif
										
										@if (isset($product->descricao))
											<p class=""> {{ str_limit($product->descricao, 100) }} </p>
										@endif

										<input type="hidden" name="produto_id" value="{{ $politica->produto_id }}"/>
										<input type="hidden" name="politica_id" value="{{ $politica->politica_id }}"/>
										<input type="hidden" name="aluno_id" value="{{ $politica->aluno_id }}"/>
										<input type="hidden" name="evento_id" value="{{ $politica->event_id }}"/>
										
										<input type="hidden" name="politicas[{{ $j }}][preco]" value="{{ str_replace(',','.',$product->price) }}"/>
										<input type="hidden" name="politicas[{{ $j }}][titulo]" value="{{ $product->title }}"/>
										
										<input type="hidden" name="politicas[{{ $j }}][politica_id]" value="{{ $politica->politica_id }}"/>
										
										@if ( $politica->tipo === 'radio')
											<ul class="container-radio">
												<li>
													<input id="produto{{ $j }}" type="radio" class="radio" name="radio[{{ $i }}]" value='{{ $j }}'/>
												</li>
												<li>
													<label for="produto{{ $j }}">R$ {{ number_format( str_replace(',','.',$product->price),2,",",".") }}</label>
												</li>
											</ul>

										@elseif ( $politica->tipo === 'checkbox')

											<ul class="container-radio">
												<li>
													<input id="produto{{ $j }}" type="checkbox" class="" name="politicas[{{ $j }}][option]" value='1'/>
												</li>
												<li>
													<label for="produto{{ $j }}">R$ {{ number_format( str_replace(',','.',$product->price), 2, ",", ".") }}</label>
												</li>
											</ul>

										@endif
									
									</div>

								</div>
								@else
									<div class="col-sm-3">
										<div class="box-politica">
											<div class="alert alert-danger">
												Problemas ao carregar este produto.
											</div>
										</div>
									</div>
								@endif
								<?php $j++; ?>
							@endforeach
						</div>
					@endforeach
					
					<div class="clearfix"></div>
					<?php $i++; ?>
					</div>
				@endforeach
				<input type="submit" class="btn btn-blue pull-right  next-button" value="Próximo" />
				<div class="clearfix"></div>
			</form>

		</div>

	</section>

@endsection

@section('scripts')

	<script type="javascript" src="{{ asset("js") }}/slick.min.js"></script>
	<script>
		$(document).ready(function(){

			$('.slik-itens').slick({
				dots: true,
				infinite: true,
				speed: 500,
				fade: true,
				cssEase: 'linear',
				autoplay: true,
  				autoplaySpeed: 2000,
				arrows: false
			});

			$('.container-radio input[type="checkbox"]').iCheck({
				checkboxClass: 'icheckbox_flat-blue'
			});
			$('.container-radio input[type="radio"]').iCheck({
				radioClass: 'iradio_flat-blue'
			});
		})
	</script>

@endsection

