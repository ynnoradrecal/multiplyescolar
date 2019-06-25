
@extends('Loja::master')

@section('title', 'Página de Cadastro')

@section('content')
    

    <div class="container">
	    <div class="col-md-4 col-md-offset-4">

		    <div class="form-cad"> 
		    	

		    	<h1>Cadastro</h1>

		    	@if( isset($errors) && count($errors) > 0)
		    		<div class="alert alert-danger" role="alert">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
		    		</div>
		    	@endif

		    	<form method="POST" action="cadastro" accept-charset="UTF-8">
		    		<input name="_token" type="hidden" value="{{ Session::token() }}">
					
					<div class="form-group">
			            <input id="first" class="form-control" placeholder="Nome" name="nome" type="text">
			        </div>

			        <div class="form-group">
			            <input id="sobrenome" class="form-control" placeholder="Sobrenome" name="sobrenome" type="text">
			        </div>

			      	<div class="form-group">
			            <input id="email" class="form-control" placeholder="Email" name="email" type="email">
			        </div>

			        <div class="form-group">
			            <input id="telefone" class="form-control" placeholder="Telefone/Celular" name="telefone" type="text">
			        </div>

			        {{-- <div class="form-group">
			            <input id="nascimento" class="form-control" placeholder="Data de nascimento" name="data_nascimento" type="text">
			        </div>

			        <div class="form-group">
			            <select id="sexo" class="form-control" name="sexo"><option selected="selected" value="">Sexo</option><option value="M">Masculino</option><option value="F">Feminino</option></select>
			        </div> --}}

			        <div class="form-group">
			            <input class="form-control" placeholder="Senha" name="pass" value="" type="password">
			        </div>

			        <div class="form-group">
			            <input class="btn btn-lg btn-success" value="Cadastrar" type="submit">
			        </div>
			    </form>

			    

			    {{-- {!! Form::open(['route' => 'cadastrar.cliente', 'method' => 'post']) !!}

			      	{!! Form::token() !!}
					
					<div class="form-group">
			            {!! Form::text('name', $value = null, ['id' => 'nome', 'class'=>'form-control', 'placeholder'=> 'Nome']) !!}
			        </div>

			      	<div class="form-group">
			            {!! Form::email('email', $value = null, ['id' => 'email', 'class'=>'form-control', 'placeholder'=> 'Email']) !!}
			        </div>

			        <div class="form-group">
			            {!! Form::text('data_nascimento', $value = null, ['id' => 'nascimento', 'class'=>'form-control', 'placeholder'=> 'Data de nascimento']) !!}
			        </div>

			        <div class="form-group">
			            {!! Form::select('size', ['M' => 'Masculino', 'F' => 'Feminino'], null, ['id' => 'sexo', 'class'=>'form-control', 'placeholder'=> 'Sexo']) !!}
			        </div>

			        <div class="form-group">
			            {!! Form::password('pass', ['class'=>'form-control', 'placeholder'=> 'Senha']) !!}
			        </div>

			        <div class="form-group">
			            {!! Form::submit('Cadastrar', ['class'=>'btn btn-lg btn-success']) !!}
			        </div>

			    {!! Form::close() !!} --}}

		    </div>
	    </div>
    </div><!-- /.container -->

@endsection


   
  

