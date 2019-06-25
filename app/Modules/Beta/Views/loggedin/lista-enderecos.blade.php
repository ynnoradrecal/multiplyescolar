@extends('Loja::master')

@section('title', 'Dados do cliente - Atualizar dados')

@section('css')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.block-grid/latest/bootstrap3-block-grid.min.css">
@endsection

@section('content')

	<section id="breadcrumb">
		
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines" />
		
		<div class="container">

			<div class="col-xs-12 text-center">

				<i class="fa fa-folder-open" aria-hidden="true"></i>
				<h1>ÁREA DO CLIENTE</h1>
				<small><b>Home</b> / Área do Cliente / Meus Endereços </small>

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

						@if( count($enderecos) > 0 )

							<h1><i class="fa fa-map-marker"></i> MEUS ENDEREÇOS</h1>

							<form action="" method="post">
								{{ csrf_field() }}
								@foreach ($enderecos as $endereco)
									
									<div class="col-md-6">
										
										<div class="list-endereco">
											
											<div class="header-box">
												<p class="nome">{{ $cliente->name .' '. $cliente->last_name }}</p>
												<p class="endereco">
													<span>{{ $endereco->logradouro }}, {{ $endereco->numero }}
													<span>{{ $endereco->bairro }} - {{ $endereco->cidade }} - {{ $endereco->estado }}</span>
													<span>CEP {{ $endereco->cep }}</span>
												</p>
												<p class="endereco">
													<div class="btn-group" role="group" aria-label="">
														<a href="{{ url('minha-conta/endereco/'. $endereco->id) }}" class="btn btn-azul btn-sm">Editar</a>
														<a href="{{ url('minha-conta/endereco/'. $endereco->id.'/delete') }}" class="btn btn-danger btn-sm">Excluir</a>
													</div>
												</p>
											</div>

											<div class="footer-box">

												<div class="media">
													<div class="media-left">
														<input type="hidden" name="id" value="{{ $endereco->id }}" />
														<input id="endereco-{{ $endereco->id }}" type="radio" name="endereco" idEndereco="{{ $endereco->id }}" value="{{ $endereco->id }}" {{ $endereco->entrega == 1 ? 'checked': '' }} />
													</div>
													<div class="media-body">
														<label for="endereco-{{ $endereco->id }}">Selecionar como principal</label>
													</div>
												</div>
												
											</div>

										</div>

									</div>

								@endforeach
							</form>

						@else
							<div class="alert alert-danger" role="alert"><strong>Olá {{ Auth::guard('cliente')->user()->name }} {{ Auth::guard('cliente')->user()->name }},</strong> notamos que você não possui nenhum endereço cadastrado, por favor cadastre.</div>
						@endif

						<div class="clearfix"></div>

						<div class="add-endereco text-center">
							<a href="{{ route('form.add.endereco') }}" class="btn btn-blue btn-lg">
								Novo endereço
							</a>
						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

@endsection

@section('scripts')

	<script>
		$(document).ready(function(){
			
			$('.footer-box input[type="radio"]').iCheck({
				checkboxClass: 'icheckbox_flat-blue',
				radioClass: 'iradio_flat-blue'
			});
			$('.footer-box input[type="radio"]').on('ifChecked', function(){
					var idEndereco = $(this).attr("idEndereco");
					var idCliente = {{ Auth::guard('cliente')->user()->id }}

					$.ajax({
						 headers: {
        					'X-CSRF-TOKEN': $('input[name="_token"]').val()
   						},
						dataType: 'json',
						url: "{{ url('') }}/minha-conta/"+ idCliente +"/endereco/principal/"+ idEndereco,
						method: 'GET',
						success: function(response){
							console.log(response);
						}
							
					});
			});
		});
	</script>
@endsection
