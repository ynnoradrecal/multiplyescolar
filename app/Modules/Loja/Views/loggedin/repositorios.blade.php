@extends('Loja::master')

@section('title', 'Galeria')

@section('css')
	
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css">
	<style type="text/css" media="screen">
		
		.grid-item {
			float: left;
			padding: 10px;
		}

	</style>

@endsection

   
@section('content')

	<section id="breadcrumb">
		<!-- <img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines"> -->
		<div class="container">

			<div class="col-xs-12 text-center">

				<i class="fa fa-th" aria-hidden="true"></i>
				<h1>GALERIA</h1>
				<small><b>Home</b> / Galeria</small>

			</div>

		</div>

	</section>


	@include('Loja::templates.steps')

  	<section id="repositorio">

		<div class="container">

			<div class="row">

				<div class="col-xs-12 col-md-12">
					
					@php 

						$base = $evento['capa'][0]['path'];
						$capa = $evento['capa'][0]['capa'];
						
						$image = $base .'/'. $capa;
						
						//http://via.placeholder.com/350x250

					@endphp 

					<div class="jumbotron" style="margin-bottom:5px;">

						<h1>{{ $evento['name'] }}</h1>

						<!-- <figure class="thumbnail" style="border:1px solid #ccc;overflow:hidden;margin-bottom:0;">
							<img src="{{ asset($image) }}" alt="..." style="width:100%;height:240px;">
						</figure>  -->
						
						<br>
						
						<p>{{ $evento['description'] }}</p>
												
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1"> <i class="fa fa-search fa-2x"></i> </span>
							<input type="text" class="form-control input-lg" placeholder="Digite aqui Nome da Galeria que deseja." name="filter">
						</div>

						<div class="" style="position:relative;">
							<ul class="list">
								<li><a href="#">...</a></li>
							</ul>
						</div>

						<br>
						<div class="text-left">
							<a href="{{ url('/eventos') }}"><i class="fa fa-reply"></i> SEÇÃO ANTERIOR</a>
						</div>

					</div>
				</div>

			</div>
				
			<div class="row">
				<div class="col-xs-12">&nbsp;</div>
			</div>

			<div class="row">
	
				<div class="col-xs-12 gallery">
					
					@php 
						$collect = collect($repositorios); $i = 0;
					@endphp

					@foreach ($collect->chunk(3) as $chunk)
				
						<div class="row" style="margin-bottom: 10px">
													
							@foreach ( $chunk as $repositorio )
							
								<div class="col-md-4 col-sm-4 col-xs-12">
										
									@if($repositorio->pin)
										<a href="#" class="linkRepositorio" data-toggle="modal" data-target="#modalPin" data-repositorio="{{ $repositorio->id }}" style="border: 1px solid #ccc;display:block;padding: 14px 0;height:120px;position:relative;">
											
											<div class="loop-box">

												<div class="col-md-4 col-xs-4">
													@if ( $repositorio->src )
														<img src="{{ asset('uploads/repositorio')}}/{{ $repositorio->id }}/thumb_small/{{ $repositorio->src }}" class="center-block thumbnail" width="104" height="94" />
														<!-- <img src="http://via.placeholder.com/89x80" class="center-block thumbnail" /> -->
													@else
														<!-- <img src="http://via.placeholder.com/89x80" class="center-block thumbnail" /> -->
														<img src="{{ asset('images')}}/icon-multiply.png" class="center-block thumbnail" width="104" height="94" />
													@endif	
												</div>

												<div class="col-md-8 col-xs-8">
													@if ($repositorio->nome_aluno == null)
														<div class="loop-content">
															<h4 style="margin-bottom:4px;">{{ $repositorio->product_name }}</h4>
															<i class="fa fa-picture-o"></i> Visualizar Fotos
														</div>
													@else
														<div class="loop-content">
															<h4><strong>{{ $repositorio->product_name }}</strong></h4>
															<p>Aluno: {{ $repositorio->nome_aluno }}</p>
														</div>
													@endif
												</div>

												<div class="tag" style="position:absolute;bottom:10px;right:10px;">
													<span class="label label-danger">" Privado</span>
												</div>

												<div class="clearfix"></div>

											</div>
											
										</a>
									@else
										<a href='{{ url("/")."/galerias/". $repositorio->id }}' class="linkRepositorio" style="border: 1px solid #ccc;display:block;padding: 14px 0;height:120px;position:relative;">
											
											<div class="loop-box">

												<div class="col-md-4 col-xs-4">
													@if ( $repositorio->src )
														<img src="{{ asset('uploads/repositorio')}}/{{ $repositorio->id }}/thumb_small/{{ $repositorio->src }}" class="center-block thumbnail" width="100%" />
													@else
														<img src="{{ asset('images')}}/icon-multiply.png" class="center-block thumbnail" width="100%" />
													@endif	
												</div>

												<div class="col-md-8 col-xs-8">
													@if ($repositorio->nome_aluno == null)
														<div class="loop-content">
															<h4 style="margin-bottom:4px;">{{ $repositorio->product_name }}</h4>
															<i class="fa fa-picture-o"></i> Visualizar Fotos
														</div>
													@else
														<div class="loop-content">
															<h4><strong>{{ $repositorio->product_name }}</strong></h4>
															<p>Aluno: {{ $repositorio->nome_aluno }}</p>
														</div>
													@endif

												</div>

												<div class="tag" style="position:absolute;bottom:10px;right:10px;">
													<span class="label label-success">" Publico</span>
												</div>

												<div class="clearfix"></div>

											</div>
											
										</a>									
									@endif

								</div>

							@endforeach

						</div>

					@endforeach
			</div>

		</div>

  	</section>

	<div class="modal fade" tabindex="-1" role="dialog" id="modalPin" aria-labelledby="modalPin">
		<div  class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-barcode"></i> PIN</h4>
			</div>
			<form id="formularioPin" method="post">
				<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="event_id" value="{{ $evento['id'] }}" />
					<input type="hidden" name="repositorio_id" value="" />
					<div class="form-group">
						<label class="control-label">Informe o PIN de Acesso</label>
						<input id="txtPin" class="form-control" type="text" name="pin" value="" />
						<span id="txtPinError" class="help-block"> </span>
						<span>* caso não possua o código, por favor entre em contato conosco.</span>
					</div>
				</div>
				<div class="modal-footer">
					<button id="enviaForm" type="submit" class="btn btn-primary btn-md">
						<i class="fa fa-refresh fa-spin fa-1x" style="display: none;"></i>&nbsp;&nbsp;Autorizar Acesso
					</button>
				</div>
			</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


@endsection

@section('scripts')

	<script>

		$(document).ready(function(){
			
			$('a.back').click(function(){
				parent.history.back();
				return false;
			});

			$('.linkRepositorio').click(function(){
				var repo_id = $(this).data('repositorio');
				$('form').find('input[name="repositorio_id"]').val(repo_id);
			});

			$('#enviaForm').click(function(){
				$(this).find('i').css('display','inline-block');
			})

			$('#formularioPin').submit(function(e){
				e.preventDefault();

				if( $('#txtPin').val() == ''){
					$('.form-group').addClass('has-error');
					$('#txtPinError').text('Este campo é obrigatório.')
					$(this).find('i').css('display','none');

				}else{

					$.ajax({
						method: "POST",
						url: "{{ url('/')}}/eventos/checkPin",
						data: $(this).serialize(),
						success: function(result){
							if(result.error){
								$('.form-group').addClass('has-error');
								$('#txtPinError').text( result.error );
								$('#enviaForm i').css('display','none');
							}

							if(result.success){
								window.location.href = result.url;
							}
						}
					});
				}
			})
		})

	</script>

@endsection
