@extends('Loja::master')

@section('title', 'Galeria')

@section('css')
	
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css">
	<style type="text/css" media="screen">
		
		/*.grid-item {
			float: left;
			padding: 10px;
		}*/

		body {
			/*background: rgb(245, 245, 245);
			font-size: 1em;
			letter-spacing: 0.1em;
			line-height: 1.6em;
			font-family: 'Microsoft Yahei';
			font-weight: lighter;
			color: rgba(0, 0, 0, 0.6); */
			overflow-x: hidden;
		}

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
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">
		<div class="container">

			<div class="col-md-5">

				<h1>Galeria de Imagens</h1>

			</div>

			<div class="col-md-2 text-center">
				<i class="fa fa-th" aria-hidden="true"></i>
			</div>

			<div class="col-md-5 text-right">

				<ul>
					<li>Home</li>
					<li>/</li>
					<li>Galeria</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">

	</section>


	<section id="breadcrumb-compra">

		<div class="container">

			<ul>
				<div class="col-md-12">
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
					<li class="active"><span>3</span> Fotos </li>
					<li><span>4</span> Formato </li>
					<li><span>5</span> Opções </li>
					<li><span>6</span> Entrega </li>
					<li><span>7</span> Pagamento </li>
				</div>
			</ul>

		</div>

	</section>

	<section id="galeria">

		<div class="container">
			<div class="col-md-12">
				<h1>Por favor confirme suas imagens</h1>
			</div>		
			
			@if (count($errors) > 0)
				<div class="col-md-11">
					<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4><strong>Alerta de Erro</strong></h4>
						<p>{{ $errors->first() }}.</p>
					</div>
				</div>
				<div class="clearfix"></div>
			@endif

			<form action="{{ url('/') }}/add-to-cart/images" method="POST">
				{{-- <input name="_token" type="hidden" value="{{ Session::token() }}"> --}}
				{{ csrf_field() }}
				{{-- <input name="produto_id" type="hidden" value="{{ $produto['produto_id'] }}"> --}}
				<input name="confirmacao" type="hidden" value="1" />

				<?php $i = 0; ?>
					<ul id="waterfall">
						{{-- {{ dd($galeria )}} --}}
						@foreach ( $galeria as $val )

						<?php 
							$urlArray = explode('/', $val->url);
							$imageName = last($urlArray); 
						?>

							<li>
								<div>
									<div class="">

										<div class="single-image">
											{{-- <img src="{{ asset($val->url) }}" class="img-responsive"  /> --}}
											<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Clique para dicionar esta imagem a sua lista.">
												<img src="{{ asset('uploads/repositorio') }}/{{ $urlArray[3] }}/thumb/{{ $imageName }}" class="img-responsive"  />
											</a>
											
											<div class="buttons">

												<div class="pull-right">

													<div class="single-button">
														
														<!--<div class="checkbox">
															
															<label for="check-{{ $i }}"></label>
														</div>-->
														<input id="check-{{ $i }}" class="" type="checkbox" name="imagem[{{ $i }}][id]" value="{{ $val->id }}">													
														
														<input id="mensagem-{{ $i }}" type="hidden" name="imagem[{{ $i }}][mensagem]" value="">

														<a href="javascript:void(0);" onclick="return openCommentModal('mensagem-{{ $i }}');"  data-toggle="tooltip" data-placement="bottom" title="Adicione um comentário!">
															<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
														</a>
													
														<a href="{{ asset($val->url) }}" data-lightbox="gallery" data-toggle="tooltip" data-placement="bottom" title="Ampliar imagem.">
															<i class="fa fa-plus" aria-hidden="true"></i>
														</a>

													</div>

													<div class="clearfix"></div>
												</div>

												<div class="clearfix"></div>
											</div>

										</div>

									</div>
								</div>

								<?php $i++; ?>
							</li>
						@endforeach
					</ul>

					<div class="buttons-body-foot">
						<input type="submit" class="btn btn-blue pull-right next-button" value="Próximo" />
						<a href="#" class="back btn btn-gray pull-right">Escolher mais fotos</a>
					</div>
					<div class="clearfix"></div>

			</form>
		</div>
			
		
  	</section>


@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('/js/newWaterfall.js')}}"></script>
	<script type="text/javascript">

		$('a.back').click(function(){
			parent.history.back();
			return false;
		});
		
		lightbox.option({
			'resizeDuration': 100,
			'wrapAround': true,
			'alwaysShowNavOnTouchDevices': false
		})
		
		 $(document).ready(function (){

			$('[data-toggle="tooltip"]').tooltip({
				container: 'body'
			});

			$('#waterfall').NewWaterfall({
				width: 270,
				delay: 100,
			});

			$('.single-image').mouseover(function(){
				$(this).find('.buttons').stop().animate({
					'margin-top':'-45px'
					}, 300);
			})

			$('.single-image').mouseleave(function(){
				$(this).find('.buttons').stop().animate({
					'margin-top':'1px'
					}, 300);
			})

			
			$('.single-button input[type="checkbox"]').iCheck('check');

			$('.single-button input[type="checkbox"]').iCheck({
				checkboxClass: 'icheckbox_flat-blue',
				radioClass: 'iradio_flat-blue'
			});

			$('.single-button input[type="checkbox"]:checked').each(function(){
				$(this).parents('.single-image').css('border', 'solid 3px #009DE1');
			})


			$('.single-button input[type="checkbox"]').on('ifChecked', function(event){
				$(this).parents('.single-image').css('border','solid 3px #009DE1').animate({}, 800);
			});
			$('.single-button input[type="checkbox"]').on('ifUnchecked', function(event){
				$(this).parents('.single-image').css('border', 'solid 3px #fff');
			});

			$('.single-image').click(function(){
				var $this = $(this);
				
				if($this.data('clicked')) {
					$(this).find('input[type="checkbox"]').iCheck('uncheck');
					$this.data('clicked', false);
				}
				else {
					$this.data('clicked', true);
					$(this).find('input[type="checkbox"]').iCheck('check');
				}
			});

			

			/*$('.single-image').click(function() {
				var clicks = $(this).data('clicks');
				if (clicks) {
					$(this).find('.buttons').stop().animate({
					'margin-top':'1px'
					}, 300);
				} else {
					$(this).find('.buttons').stop().animate({
					'margin-top':'-45px'
					}, 300);
				}
				$(this).data("clicks", !clicks);
			});*/

		});

	</script>
@endsection

