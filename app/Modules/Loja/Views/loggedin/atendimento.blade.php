@extends('Loja::master')

@section('title', 'Dados do cliente - Atendimento')

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
					<li>Atendimento</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">
	</section>

	<section id="clientes">

		<div class="container">

			<div class="col-md-4">
				{{--  Instancia Sidebar  --}}
				@include('Loja::templates.sidebar-logedin')

			</div>

			<div class="col-md-8">

				<div class="content-client-data">
					<h1>Atendimento</h1>
					
					<br>

					@if(session("success"))
						<div class="alert alert-success alert-dismissible fade in" role="alert"> 
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<p>Agradecemos o contato, nossa equipe retornará assim que possível!</p>
						</div>
					@endif
					
					<form action="" method="post">
						
						{{ csrf_field() }}
						
						<input type="hidden" name="form" value="support" />
						<input type="hidden" name="name" value="{{ Auth::guard('cliente')->user()->name.' '.Auth::guard('cliente')->user()->last_name }}" />
						<input type="hidden" name="email" value="{{ Auth::guard('cliente')->user()->email }}" />

						<div class="col-md-12">
							
							<div class="form-group @if ($errors->has('assunto')) has-error @endif">
								
								<p>Como podemos te ajudar?</p>
								
								<select name="assunto" id="">
									<option value="">Selecione</option>
									<option value="devolucao">Devolução</option>
									<option value="pagamento">Pagamento</option>
									<option value="entrega">Processo de Entrega</option>
									<option value="promocao">Promoções</option>
									<option value="desconto">Desconto</option>
								</select>
								@if ($errors->has('assunto')) <span class="help-block">Escolha um dos assuntos na lista.</span> @endif

							</div>
							
						</div>

						<div class="col-md-12">
							<div class="form-group @if ($errors->has('assunto')) has-error @endif">
								<textarea class="form-control" name="mensagem" placeholder="Digite sua mensagem..."></textarea>
								@if ($errors->has('mensagem')) <span class="help-block">Campo de preenchimento obrigatório.</span> @endif
							</div>
						</div>

						<div class="col-md-12">
							<input class="btn btn-blue btn-lg" type="submit" value="Enviar" />
						</div>

					</form>

				</div>

			</div>

		</div>

	</section>

@endsection
