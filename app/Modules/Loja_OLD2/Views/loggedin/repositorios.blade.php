@extends('Loja::master')

@section('title', 'Lista de Alunos')

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
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">
		<div class="container">

			<div class="col-md-5">
				<h1>Lista</h1>
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
				<div class="col-md-12">
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Eventos 
					</li>
					<li class="active"><span>2</span> Galerias</li>
					<li><span>3</span> Fotos </li>
					<li><span>4</span> Formato </li>
					<li><span>5</span> Opções </li>
					<li><span>6</span> Entrega </li>
					<li><span>7</span> Pagamento </li>
				</div>
			</ul>

		</div>

	</section>

  	<section id="repositorio">

		<div class="container">
			<div class="row">
				<div class="col-md-5 left">
					<div class="box-evento text-center">
						<h3 class="text-center">{{ $evento['name'] }}</h3>
						<hr class="20p" />
						<div class="content-evento">
							<img src="{{ asset($evento['capa'][0]['path'].'/'.$evento['capa'][0]['capa']) }}" class="img-responsive" />
							<br>
							<p class="text-center">{{ $evento['description'] }}</p>
							<a href="#" class="back btn btn-gray text-center">Voltar a Lista de Eventos</a>
						</div>
					</div>
				</div>

				<div class="col-md-7 right">
					
					<?php $i = 0; ?>
					
					{{-- {{ dd($repositorios) }} --}}
					
					<?php $collect = collect($repositorios); ?>
					
					@foreach ($collect->chunk(2) as $chunk)
						
						<div class="row">

							@foreach ( $chunk as $repositorio )
							
								<div class="col-md-6 col-xs-12">
										
									@if ($repositorio->pin)
										<a href="#" class="linkRepositorio" data-toggle="modal" data-target="#modalPin" data-repositorio="{{ $repositorio->id }}">
											
											<div class="loop-box">

												<div class="col-md-3 col-xs-2">
													<img src="{{ asset('images')}}/icon-multiply.png" class="center-block" />
												</div>

												<div class="col-md-9 col-xs-9">
													@if ($repositorio->nome_aluno == null)
														<div class="loop-content">
															<h4><strong>{{ $repositorio->product_name }}</strong></h4>
															<p>Acesse a galeria.<br>
															Conteúdo privado.</p>
														</div>
													@else
														<div class="loop-content">
															<h4><strong>{{ $repositorio->product_name }}</strong></h4>
															<p>Aluno: {{ $repositorio->nome_aluno }} <br>
															Conteúdo privado.</p>
														</div>
													@endif

												</div>

												<div class="clearfix"></div>

											</div>
											
										</a>
									@else
										<a href='{{ url("/")."/galerias/". $repositorio->id }}' class="linkRepositorio">
											
											<div class="loop-box">

												<div class="col-md-3 col-xs-2">
													<img src="{{ asset('images')}}/icon-multiply.png" class="center-block" />
												</div>

												<div class="col-md-9 col-xs-9">
													@if ($repositorio->nome_aluno == null)
														<div class="loop-content">
															<h4><strong>{{ $repositorio->product_name }}</strong></h4>
															<p>Nenhum aluno referenciado <br>
															Conteúdo público.</p>
														</div>
													@else
														<div class="loop-content">
															<h4><strong>{{ $repositorio->product_name }}</strong></h4>
															<p>Aluno: {{ $repositorio->nome_aluno }}<br>
															Conteúdo público.</p>
														</div>
													@endif

												</div>

												<div class="clearfix"></div>

											</div>
											
										</a>									
									@endif

								</div>

								@if ($i & 1)
									<div class="clearfix"></div>
								@endif
								<?php $i++; ?>
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
				<h4 class="modal-title">Digite o código PIN</h4>
			</div>
			<form id="formularioPin" method="post">
				<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="event_id" value="{{ $evento['id'] }}" />
					<input type="hidden" name="repositorio_id" value="" />
					<div class="form-group">
						<label class="control-label">Informe o PIN:</label>
						<input id="txtPin" class="form-control" type="text" name="pin" value="" />
						<span id="txtPinError" class="help-block"> </span>
						<span>* caso não possua o código, por favor entre em contato conosco.</span>
					</div>
				</div>
				<div class="modal-footer">
					<button id="enviaForm" type="submit" class="btn btn-primary btn-md">Enviar PIN &nbsp;  <i class="fa fa-refresh fa-spin fa-1x" style="display: none;"></i></button>
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

