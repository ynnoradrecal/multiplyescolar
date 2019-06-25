@extends('Loja::master')

@section('title', 'Endereço')

@section('content')

    <div class="container">

	    <div class="enderecos">
		    <h1>Edita formulário</h1>

		    <div class="col-md-4"> 

		    	@if( isset($errors) && count($errors) > 0)
		    		<div class="alert alert-danger" role="alert">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
		    		</div>
		    	@endif


		    	<form method="POST" accept-charset="UTF-8">

		    		<input name="_method" value="PUT" type="hidden">
		    		{{ csrf_field() }}

		    		<div class="form-group">
		    			<input class="form-control" name="id" value="{{ $endereco->id }}" type="text" disabled>
		    		</div>

		    		<div class="form-group">
		    			<input class="form-control" name="rua" value="{{ $endereco->rua }}" type="text">
		    		</div>
		    		
		    		<div class="form-group">
		    			<input class="form-control" name="num" value="{{ $endereco->num }}" type="text">
		    		</div>
		    		
			    	<div class="form-group">
			    		<input class="form-control" name="cep" value="{{ $endereco->cep }}" type="text">
			    	</div>

		    		<div class="form-group">
                        <input class="btn btn-success" value="Enviar" type="submit">
                    </div>

		    	</form>
		    
		    </div>

	    </div>

    </div><!-- /.container -->

@endsection