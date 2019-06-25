@extends('Loja::master')

@section('title', 'Dados do cliente - Atualizar dados')

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
					<li>Dados cadastrais</li>
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

						@if ( isset($success) )
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
								<strong>Parabéns:</strong> {{ $success }}. 
							</div>
						@endif
						
						<h1>Dados cadastrais</h1>

						<div class="form-cad">
							
							<form action="{{ route('update.dados.cliente') }}" method="post">

								{{ csrf_field() }}

								<?php $cliente = Auth::guard('cliente')->user(); ?>

								<input type="hidden" name="id" value="{{ Auth::guard('cliente')->user()->id }}" >

								<div class="col-md-6">
									<div class="form-group @if ($errors->has('name')) has-error @endif">
										<input class="form-control" type="text" name="name" value="{{ ($cliente->name === '') ? old('name') : $cliente->name }}" placeholder="Nome" />
									    @if ($errors->has('name')) <span class="help-block">O campo "Nome" é obrigatório</span> @endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group @if ($errors->has('last_name')) has-error @endif">
										<input class="form-control" type="text" name="last_name" value="{{ ($cliente->last_name === '') ? old('last_name') : $cliente->last_name }}" placeholder="Sobrenome"  />
										@if ($errors->has('last_name')) <span class="help-block">O campo "Sobrenome" é obrigatório</span> @endif
									</div>
								</div>
								<div class="clearfix"></div>

								<div class="col-md-6">
									<div class="form-group">
										<input id="disabledInput"" class="form-control" type="email" name="email" value="{{ $cliente->email }}" placeholder="Email"  readonly="readonly" />
										
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group @if ($errors->has('telefone')) has-error @endif">
										<input class="form-control" type="text" name="telefone" value="{{ ($cliente->telefone === '') ? old('telefone') : $cliente->telefone }}" placeholder="Telefone"  />
										@if ($errors->has('telefone')) <span class="help-block">O campo "Telefone" é obrigatório</span> @endif
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group @if ($errors->has('celular')) has-error @endif">
										<input class="form-control" type="text" name="celular" value="{{ ($cliente->celular === '') ? old('celular') : $cliente->celular }}" placeholder="Celular"  />
										@if ($errors->has('celular')) <span class="help-block">O campo "Celular" é obrigatório</span> @endif
									</div>
								</div>
								<div class="clearfix"></div>

								<!-- <div class="col-md-4">
									<div class="form-group @if ($errors->has('data_nascimento')) has-error @endif">
										<input class="form-control" type="text" name="data_nascimento" value="{{ ($cliente->data_nascimento === '') ? old('data_nascimento') : $cliente->data_nascimento }}" placeholder="Data de nascimento"  />
										@if ($errors->has('data_nascimento')) <span class="help-block">O campo "Data de nascimento" é obrigatório</span> @endif
									</div>
								</div> -->

								<!-- <div class="col-md-4">
									<div class="form-group @if ($errors->has('sexo')) has-error @endif">
										<select name="sexo" id="">
											<option value="">Escolha o seu sexo </option>
											<option value="M" {{ ($cliente->sexo == 'M') ? 'selected' : '' }}>Masculino</option>
											<option value="F" {{ ($cliente->sexo == 'F') ? 'selected' : '' }}>Feminino</option>
										</select>
										@if ($errors->has('sexo')) <span class="help-block">O campo "Sexo" é obrigatório</span> @endif
									</div>
								</div> -->

								<div class="col-md-4">
									<div class="form-group @if ($errors->has('cpf')) has-error @endif">
										<input class="form-control" type="text" name="cpf" value="{{ ($cliente->cpf === '') ? old('cpf') : $cliente->cpf }}" placeholder="CPF"  />
										@if ($errors->has('cpf')) <span class="help-block">{{ $errors->first('cpf') }}</span> @endif
									</div>
								</div>
								<div class="clearfix"></div>
								
								<div class="col-md-12">
									<h3>Alterar senha</h3>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<input class="form-control" type="password" name="password" value="" placeholder="Senha" />
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<input class="form-control" type="password" name="confirm-password" value="" placeholder="Confirme sua senha" />
									</div>
								</div>
								
									
								<div class="col-md-12">
									<input class="btn btn-lg btn-blue" value="Salvar" type="submit" />
								</div>
								<div class="col-md-12">
									<br>
									<span class="obs">** Caso não queira mudar a senha, deixe os campos em branco.</span>
								</div>

							</form>


						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

@endsection
