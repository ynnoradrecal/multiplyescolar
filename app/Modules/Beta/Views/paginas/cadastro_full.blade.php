@section('title', 'Página de Cadastro Full')

@section('content')
    

    <div class="container">
	    <div class="col-md-4 col-md-offset-4"> 

		    <div class="form-cad"> 
		    	<h1>Cadastro Full</h1>

		      {!! Form::open(['route' => 'editar.cliente', 'method' => 'post']) !!}
				
				<div class="form-group">
		            {!! Form::text('name', $value = null, ['class'=>'form-control', 'placeholder'=> 'Nome']) !!}
		        </div>

		      	<div class="form-group">
		            {!! Form::email('email', $value = null, ['class'=>'form-control', 'placeholder'=> 'Email']) !!}
		        </div>

		        <div class="form-group">
		            {!! Form::password('pass', ['class'=>'form-control', 'placeholder'=> 'Senha']) !!}
		        </div>

		        <div class="form-group">
		            {!! Form::submit('Cadastrar', ['class'=>'btn btn-success']) !!}
		        </div>

		      {!! Form::close() !!}
		    </div>

	    </div>

    </div><!-- /.container -->

@endsection