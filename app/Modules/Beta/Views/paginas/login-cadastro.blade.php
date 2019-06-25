
@extends('Beta::master')

@section('title', 'Login - Cadastro')

@section('content')

	<section id="breadcrumb">
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">
		<div class="container">

			<div class="col-xs-12 text-center">

				<i class="fa fa-users" aria-hidden="true"></i>
				<h1>CLIENTES</h1>
				<small><b>Home</b> / Cliente</small>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">
	</section>

	<section id="login-cadastro">

		
		
		<div class="container">
			
			<div class="col-md-5 col-sm-6 col-xs-12">
				<h3 class="text-left"> <i class="fa fa-unlock"></i> Login</h3>
				<form method="post" action="login">
					{{-- <input name="_token" type="hidden" value="{{ Session::token() }}"> --}}
					{{ csrf_field() }}

					@if ( $errors->has('message') )
					<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<p>Email ou senha estão incorretos</p>
					</div>
					@endif

					@if ( session('facebook') )
					<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<p>Falha ao tentar conectar com o Facebook, por favor tente mais tarde.</p>
					</div>
					@endif

					<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
						<label>E-mail*</label>
						<input id="email" class="form-control" value="{{ old('email') }}"  name="email" type="email">
						{!! $errors->first('email', '<p class="help-block">Este campo é obrigatório.</p>') !!}
					</div>

					<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
						<label>Senha*</label>
						<input class="form-control" name="password" value="{{ old('password') }}" type="password">
						{!! $errors->first('password', '<p class="help-block">Este campo é obrigatório.</p>') !!}
					</div>

					<div class="form-group">
						<button class="btn btn-lg btn-blue" name="login" type="submit">
							Acessar <i class="fa fa-angle-double-right"></i>
						</button>
					</div>

					<div class="alert alert-danger fade out" role="alert"> 
						<p><i class="fa fa-exclamation-triangle"></i> "E-mail" e/ou "Senha" estão incorretos!</p>
					</div>

				</form>
				<div class="col-xs-12 text-center">
					<br>
					<a href="{{ url('login/facebook') }}" class="btn btn-lg btn-blue btn-facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i> &nbsp;Logar com Facebook</a>
					<br><span class="info">Ao criar uma conta, você indica que concorda com as <a href="#">Políticas de Compra do Multiply Escolar.</a></span>
				</div>
			</div>

			<div class="col-md-5 col-sm-6 col-xs-12 col-md-offset-2">
				<h3 class="text-left"><i class="fa fa-folder-open"></i> Cadastro</h3>
				<form method="post" action="cadastro">
					{{ csrf_field()}}

					<div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
						<label for="nome">Nome*</label>
						<input id="first" class="form-control" name="nome" value="{{ old('nome') }}" type="text" >
						{!! $errors->first('nome', '<p class="help-block">Este campo é obrigatório.</p>') !!}
					</div>

					<div class="form-group {{ $errors->has('sobrenome') ? 'has-error' : ''}}">
						<label for="sobrenome">Sobrenome*</label>
						<input id="sobrenome" class="form-control" name="sobrenome" value="{{ old('sobrenome') }}" type="text" >
						{!! $errors->first('sobrenome', '<p class="help-block">Este campo é obrigatório.</p>') !!}
					</div>

					<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
						<label for="email">E-mail*</label>
						<input id="email" class="form-control" name="email" value="{{ old('email') }}" type="email" required>
						{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
					</div>

					<div class="form-group {{ $errors->has('pass') ? 'has-error' : ''}}">
						<label for="senha">Senha*</label>
						<input class="form-control" name="pass" value="" type="password" required>
						{!! $errors->first('pass', '<p class="help-block">Este campo é obrigatório.</p>') !!}
					</div>

					<div class="form-group input-checkbox {{ $errors->has('check') ? 'has-error' : ''}}">
						<div class="row">
							<div class="col-xs-1 col-sm-1">
								<input id="check" class="form-control" name="check" value="Declaro que li e concordo com todos os termos do contrato" type="checkbox" checked />
							</div>
							<div class="col-xs-10 col-sm-10">
								<label for="check">*Lí e aceito as condições.</label> <a href="#">Ler condições</a>
							</div>
							<div class="col-sm-12">
								{!! $errors->first('check', '<p class="help-block">A aceitação dos termos é obrigatória.</p>') !!}
							</div>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="form-group">
						<button class="btn btn-lg btn-blue" name="cadastrar" type="submit">
							Cadastrar <i class="fa fa-angle-double-right"></i>
						</button>
					</div>

					<div class="alert alert-danger fade out" role="alert"> 
						<p><i class="fa fa-exclamation-triangle"></i> <span>...</span></p>
					</div>
				</form>
			</div>
			

			<?php /*
			<div class="col-sm-4 col-sm-offset-4">

				<h3 class="title-login-cadastro text-center">Login</h3>

				<nav class="text-center nav-tab">
					<ul>
						<li>
							<a id="login-tab" href="#login" class="active" role="tab" data-toggle="tab" aria-controls="login" aria-expanded="false">Login</a>
						</li>
						<li>
							<a id="cadastro-tab" href="#cadastro" role="tab" data-toggle="tab" aria-controls="cadastro" aria-expanded="false">Cadastro</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="tab-content">

				<div class="tab-pane fade {{ session('form') == 'cadastro' ? '' : 'active in'}}" role="tabpanel" id="login" aria-labelledby="login-tab">


					<div class="col-md-4 col-md-offset-4">

						<div class="form-cad">

							{{-- @if( isset($errors) && count($errors) > 0)
								<div class="alert alert-danger" role="alert">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif --}}

							@if ( session('cad-success') )
								<div class="alert alert-success alert-dismissible fade in" role="alert"> 
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<p><strong>Sucesso!</strong> Faça login para ver suas fotos.</p>
								</div>
							@endif

							<form method="POST" action="login" accept-charset="UTF-8">
								{{-- <input name="_token" type="hidden" value="{{ Session::token() }}"> --}}
								{{ csrf_field() }}

								@if ( $errors->has('message') )
									<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
										<p>Email ou senha estão incorretos</p>
									</div>
								@endif

								@if ( session('facebook') )
									<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
										<p>Falha ao tentar conectar com o Facebook, por favor tente mais tarde.</p>
									</div>
								@endif

								<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
									<label>E-mail</label>
									<input id="email" class="form-control" value="{{ old('email') }}"  name="email" type="email">
									{!! $errors->first('email', '<p class="help-block">Este campo é obrigatório.</p>') !!}
								</div>

								<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
									<label>Senha</label>
									<input class="form-control" name="password" value="{{ old('password') }}" type="password">
									{!! $errors->first('password', '<p class="help-block">Este campo é obrigatório.</p>') !!}
								</div>

								<div class="form-group">
									<input class="btn btn-lg btn-blue" value="Login" type="submit">
								</div>
							</form>

							<div class="row">
								<div class="col-md-12 text-center">
									<br>
									<hr>
									<a href="{{ url('login/facebook') }}" class="btn btn-lg btn-blue btn-facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i> &nbsp;Logar com Facebook</a>
									<br><span class="info">Ao criar uma conta, você indica que concorda com as <a href="#">Políticas de Compra do Multiply Escolar.</a></span>
								</div>
							</div>

						</div>

					</div>

				</div>

				{{-- @if (session('form'))
					{{ session('form') }}
				@endif --}}

				<div class="tab-pane fade {{ session('form') == 'cadastro' ? 'active in' : ''}}" role="tabpanel" id="cadastro" aria-labelledby="cadastro-tab">

					<div class="col-md-4 col-md-offset-4">

						<div class="form-cad">

							@if($errors->has('mensagem'))
								<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<p>Não foi possível salvar seus dados</p>
								</div>
							@endif

							<form method="POST" action="cadastro" accept-charset="UTF-8">
								{{ csrf_field()}}

								<div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
									<label for="nome">Nome</label>
									<input id="first" class="form-control" name="nome" value="{{ old('nome') }}" type="text" >
									 {!! $errors->first('nome', '<p class="help-block">Este campo é obrigatório.</p>') !!}
								</div>

								<div class="form-group {{ $errors->has('sobrenome') ? 'has-error' : ''}}">
									<label for="sobrenome">Sobrenome</label>
									<input id="sobrenome" class="form-control" name="sobrenome" value="{{ old('sobrenome') }}" type="text" >
									{!! $errors->first('sobrenome', '<p class="help-block">Este campo é obrigatório.</p>') !!}
								</div>

							  	<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
							  		<label for="email">E-mail</label>
									<input id="email" class="form-control" name="email" value="{{ old('email') }}" type="email" required>
									{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
								</div>

								<div class="form-group {{ $errors->has('pass') ? 'has-error' : ''}}">
									<label for="senha">Senha</label>
									<input class="form-control" name="pass" value="" type="password" required>
									{!! $errors->first('pass', '<p class="help-block">Este campo é obrigatório.</p>') !!}
								</div>

								<div class="form-group input-checkbox {{ $errors->has('check') ? 'has-error' : ''}}">
									<div class="row">
										<div class="col-xs-1 col-sm-1">
											<input id="check" class="form-control" name="check" value="Declaro que li e concordo com todos os termos do contrato" type="checkbox" checked />
										</div>
										<div class="col-xs-10 col-sm-10">
											<label for="check">Lí e aceito as condições.</label> <a href="#">Ler condições</a>
										</div>
										<div class="col-sm-12">
											{!! $errors->first('check', '<p class="help-block">A aceitação dos termos é obrigatória.</p>') !!}
										</div>
									</div>
									<div class="clearfix"></div>
								</div>

								<div class="form-group">
									<input class="btn btn-lg btn-blue" value="Cadastrar" type="submit">
								</div>
							</form>

							<div class="row">
								<div class="col-md-12 text-center">
									<hr>
									<a href="{{ url('login/facebook') }}" class="btn btn-lg btn-blue btn-facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i> &nbsp;Logar com Facebook</a>
									{{-- <br><span class="info">Ao criar uma conta, você indica que concorda com as <a href="#">Políticas de Compra do Multiply Escolar.</a></span> --}}
								</div>
							</div>

						</div>

					</div>

				</div>
			</div>
			*/ ?>

		</div>
	</section>
@endsection

