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
			overflow-x: hidden;
		}

		#waterfall {
			overflow: hidden;
		}

		#waterfall.min {
			margin: 0;
		}

		a.lp-check{
			padding: 8px 15px !important;
			background: #fff !important;
			color: #222 !important;
		}

		#waterfall li {
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
			margin: 2px;
			padding: 5px;
			background: rgb(255, 255, 255);
			transition: all 0.5s;
		}

		#waterfall li>div:hover {
			transform: translateY(-15px);
			transition: all 0.3s;
		}

		#waterfall li.min > div {
			margin: 0;
			transform: none;
			border: none;
			border-radius: 0;
			box-shadow: none;
		}

		#waterfall li.min>div:hover {
			transform: none;
			border: none;
			border-radius: 0;
			box-shadow: none;
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
		</div>

		<form action="{{ url('/') }}/add-to-cart/images" method="POST">
			{{ csrf_field() }}
			<input name="produto_id" type="hidden" value="{{ $produto['produto_id'] }}">
			<input name="current_page" type="hidden" value="1" />
			<input name="last_page" type="hidden" value="0" />
			<input name="next_page_url" type="hidden" value="0" />

			<?php $i = 0; ?>

			<div class="container">

				<ul id="waterfall" class="">
					{{--  {{ dd($galeria->lastPage) }}  --}}
					@foreach ( $galeria as $val )

						<?php  
							$imageName = last(explode('/', $val->url)); 
						?>

						<li class="ponteiro-{{ $i }}">
							<div>
								<div class="">

									<div class="single-image">

										<a href="javascript:void(0);"   data-toggle="tooltip" data-placement="auto" title="Clique para dicionar esta imagem a sua lista de compra.">
											<img id="{{ $i }}" src="{{ asset('uploads/repositorio') }}/{{ $val->produto_id }}/thumb/{{ $imageName }}" class="image-click img-responsive" title="Clique para dicionar esta imagem a sua lista." />
										</a>									

										<div class="buttons">

											<div class="pull-right">

												<div class="single-button">
													
													<!--<div class="checkbox">													
														<label for="check-{{ $i }}"></label>
													</div>-->

													<input id="check-{{ $i }}" class="" type="checkbox" name="imagem[{{ $i }}][id]" value="{{ $val->id }}" data-toggle="tooltip" data-placement="bottom" title="Escolher esta imagem.">													
													
													<input id="mensagem-{{ $i }}" type="hidden" name="imagem[{{ $i }}][mensagem]" value="">

													<a href="javascript:void(0);" onclick="return openCommentModal('mensagem-{{ $i }}');" data-toggle="tooltip" data-placement="bottom" title="Adicione um comentário!">
														<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
													</a>
												
													<a href="{{ asset($val->url) }}" data-lightbox="gallery" data-toggle="tooltip" data-title="{{ $i }}" data-placement="bottom" title="Ampliar imagem.">
														<i class="fa fa-search-plus" aria-hidden="true"></i>
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

						

				@if( $i > 29 )
					<div class="text-center">
						<br>
						<a href="#" data-loading-text="Loading..." class="readMore btn btn-lg btn-gray" autocomplete="off">Carregar mais fotos</a>
						<br>
					</div>
				@endif
			
				<div class="buttons-body-foot">
					{{-- <div class="pull-left">
						{{ $galeria->links() }}
					</div> --}}
					<hr>
					<div class="col-sm-3 col-sm-offset-7 col-xs-7  text-center">
						<a href="#" class="back btn btn-gray">Voltar as Galerias</a>
					</div>
					<div class="col-sm-2 col-xs-5 text-center">
						<input type="submit" class="btn btn-blue  next-button" value="Próximo" />
					</div>
					
				</div>
				
				<div class="clearfix"></div>

			</div>

		</form>

  	</section>


@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('/js/newWaterfall.js')}}"></script>
	<script type="text/javascript" src="{{ asset('/js/drystone.js')}}"></script>
	<script type="text/javascript">

		$(document).ready(function (){

			animatePage();

			$('a.back').click(function(){
				parent.history.back();
				return false;
			});

			lightbox.option({
				'resizeDuration': 100,
				'wrapAround': true,
				'alwaysShowNavOnTouchDevices': false
			})			
			

			$('.readMore').click(function(){

				var $btn = $(this).text('Carregando...');

				var page = $('input[name="next_page_url"]').val()

				if(page == 0){
					page = "{{ url('/galerias-json/')}}/{{ $produto['produto_id'] }}?page=2";
				}

				$.ajax({
					url: page,
					success: function(data){

						$('input[name="next_page_url"]').val(data.next_page_url);

						if( data.current_page == data.last_page ){
							$('.readMore').css('display','none');
						}

						console.log(data.data);

						var html  = '';

						for(var i =0; i < data.data.length; i++){
							html += '<li class="ponteiro-'+ ((data.from - 1) + i) +'">'
										+'<div>'
											+'<div class="">'
												+'<div class="single-image">'
													+'<a id="' + ((data.from - 1) + i) + '" href="javascript:void(0);"  data-toggle="tooltip" data-placement="auto" title="Clique para dicionar esta imagem a sua lista de compra.">'
														+'<img id="' + ((data.from - 1) + i) + '" src="{{ asset("uploads/repositorio") }}/'+ data.data[i]["produto_id"] +'/thumb' + data.data[i]["url"].replace('/uploads/repositorio/'+data.data[i]["produto_id"],"") +'" class="image-click img-responsive" title="Clique para dicionar esta imagem a sua lista." />'
													+'</a>'
													+'<div class="buttons">'
														+'<div class="pull-right">'
															+'<div class="single-button">'
																+'<input id="check-'+  ((data.from - 1) + i) +'" class="" type="checkbox" name="imagem['+  ((data.from - 1) + i) +'][id]" value="'+  data.data[i]['id'] +'" data-toggle="tooltip" data-placement="bottom" title="Escolher esta imagem.">'
																+'<input id="mensagem-'+ ((data.from - 1) + i) +'" type="hidden" name="imagem['+  ((data.from - 1) + i) +'][mensagem]" value="">'
																+'<a href="javascript:void(0);" onclick="return openCommentModal("mensagem-'+ ((data.from - 1) + i) +'");" data-toggle="tooltip" data-placement="bottom" title="Adicione um comentário!">'
																	+'<i class="fa fa-ellipsis-h" aria-hidden="true"></i>'
																+'</a>'
																+'<a href="{{ url("") }}'+ data.data[i]['url'] +'" data-title="'+ ((data.from - 1) + i) +'" data-lightbox="gallery" data-toggle="tooltip" data-placement="bottom" title="Ampliar imagem.">'
																	+'<i class="fa fa-search-plus" aria-hidden="true"></i>'
																+'</a>'
															+'</div><div class="clearfix"></div>'
														+'</div><div class="clearfix"></div>'
													+'</div>'
												+'</div>'
											+'</div>'
										+'</div>'
									+'</li>';					
						}

						$('#waterfall').append(html);
						// $('.grid').append(html);

						animatePage();

						console.log(data);

						$btn.text('Carregar mais fotos');

					}
				})				

				return false;

			});

			$('#waterfall').NewWaterfall({
				width: 270,
				delay: 100,
			});

			/*$('.grid').drystone({
				item: '.grid-item',
				gutter: 10,
				xs: [576, 2],
				sm: [768, 2],
				md: [992, 3],
				lg: [1200, 4],
				xl: 4,
			});*/

		});

		function animatePage(){

			$('.lb-check').click(function(){
				
				var id = $('.lb-caption').text();
				var get_state = $('#check-'+id).is(":checked");
				
				if( get_state ) {
					$(this).removeClass('check-active');
				} else {
					$('#check-'+id).iCheck('check');
					$(this).addClass('check-active');
				}

			});

			$('[data-toggle="tooltip"]').tooltip({
				container: 'body'
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


			// get click on image
			$('.single-image > a').find('img').off('click').on('click', function(){

				var id = this.id;

				console.log('click');

				var get_state = $('#check-'+id).is(":checked");
				
				if( get_state ) {
					$('#check-'+id).iCheck('uncheck');
				} else {				
					$('#check-'+id).iCheck('check');
				}

			});

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
		}		

	</script>
@endsection

