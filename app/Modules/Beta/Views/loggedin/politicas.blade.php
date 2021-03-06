@extends('Beta::master')

@section('title', 'Lista de Alunos')

@section('css')
	
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css" />
	<link rel="stylesheet" href="{{ asset("css") }}/slick-theme.css" />
	
	<style type="text/css" media="screen">
		
		#politicas article .header{ margin-bottom: 20px;  }
		#politicas article .header .bar-title{ width:100px;height:10px;background:#289cde;margin:0 auto; }

		#politicas .footer a{ padding: 13px 32px 10px;  }

	</style>

@endsection

   
@section('content')

	<section id="breadcrumb">
		
		<div class="container">

			<div class="col-xs-12 text-center">

				<i class="fa fa-star fa-2x"></i>
				<h1>ADICIONAIS</h1>
				<small><b>Home</b> / Adicionais</small>

			</div>

		</div>

	</section>

	@include('Beta::templates.steps')

	<section id="politicas">

		<div class="container">
			
			<div class="header row clearfix">

				<div class="col-xs-12">
					<div class="jumbotron" style="margin-bottom:5px;">

						<h1>{{ $event->name }}</h1>
						<h2>{{ $event->gallery }}</h2>
						
						<br>

						<div class="col-md-6 col-xs-6 text-left">
							<a href="{{ url('/galerias/id/'. $uids->product_id) }}"><i class="fa fa-reply"></i> SEÇÃO ANTERIOR</a>
						</div>

					</div>
					
				</div>

		    </div>

		    <br/>
			
			<article class="row adis clearfix">
				@foreach ( $politicas as $politica )
					
					@php $products = collect(json_decode($politica->list)) @endphp 

					<div class="col-xs-12 header text-center">
						<h2 class="text-uppercase">{{ $politica->nome }}</h2>
						<div class="bar-title"></div>
					</div>

					<br>
					
					<div class="content col-xs-12">
						@foreach ($products->chunk(4) as $chunk)
							<div class="row grid">
								@foreach ($chunk as $product)
									@if( $product->price != '')
										<div class="col-sm-6 col-md-3 col-xs-12">
											<h4 class="text-center title">{{ $product->title }}</h4>
											<div class="thumbnail text-center" style="position:relative;"> 

												@php 
													$images = count($product->images) != 0 ? $product->images : [];
												@endphp 

												<div class="slik-itens">
													@foreach( $images as $item )
														<a href="{{ url($product->path.'/'.$item->image) }}" data-lightbox="gallery">
															<img src="{{ url($product->path.'/'.$item->image) }}" class="img-responsive" />
														</a>
													@endforeach
												</div>

												<div class="caption"> 
													
													<h4 class="price">R$ {{ number_format( str_replace(',','.',$product->price),2,",",".") }}</h4>

													<div class="call-to-action">
														
														<input type="hidden" name="id"    value="{{ $politica->politica_id }}"/>
														<input type="hidden" name="title" value="{{ $product->title }}"/>
														<input type="hidden" name="price" value="{{ $product->price }}"/>

														<button class="btn btn-primary" 
															ref="{{ $politica->tipo === 'checkbox' ? 'check' : 'radio' }}"
															role="button">
															<i class="fa fa-{{ $politica->tipo == 'checkbox' ? 'square-o' : 'circle-o' }}"></i> 
															Selecionar
														</button>

														<button class="btn btn-success active" 
															ref="{{ $politica->tipo === 'checkbox' ? 'check' : 'radio' }}" style="display:none;" 
															role="button">
															<i class="fa fa-{{ $politica->tipo == 'checkbox' ? 'check-square-o' : 'dot-circle-o' }}"></i> 
															Selecionado 
														</button>
													</div>

												</div> 
											</div>
										</div>
									@else
										<div class="col-xs-12">
											<div class="box-politica">
												<div class="alert alert-danger">
													Problemas ao carregar este produto.
												</div>
											</div>
										</div>
									@endif
								@endforeach	
							</div>
							<div class="clearfix">&nbsp;</div>
							<hr>
						@endforeach						
					</div>		
				@endforeach
			</article>
			
			<div class="footer row">
				
				<div class="col-xs-12 text-right">
		        	<a href="#" class="btn btn-primary btn-adis" role="button">
		        		PRÓXIMO SEÇÃO&nbsp;&nbsp;<i class="fa fa-share"></i>
		        	</a>
		        </div>

		    </div>

			<!-- <form action="{{ url('/') }}/add-to-cart/options" method="post">

				
				{{ csrf_field() }}

				<?php $i = $j = 0; ?>

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
			</form> -->

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

		})
	</script>

@endsection

