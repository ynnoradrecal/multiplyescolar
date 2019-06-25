@extends('Loja::master')

@section('title', 'Contato')

@section('content')
	{{-- Dados da session(Informações da loja) --}}
	<?php $info = session()->get('lojaInfo'); ?>
	<section id="breadcrumb">
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">
		<div class="container">

			<div class="col-md-5">

				<h1>Contato</h1>

			</div>

			<div class="col-md-2 text-center">

				<i class="fa fa-map-marker" aria-hidden="true"></i>

			</div>

			<div class="col-md-5 text-right">
	
				<ul>
					<li>Home</li>
					<li>/</li>
					<li>Contato</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">
	</section>

	<section id="title-contato">

		<div class="container">
			
			<div class="col-sm-4 col-sm-offset-4">

				<h3 class="title-login-cadastro text-center">Entre em Contato</h3>

			</div>

		</div>

	</section>

	<section id="contato">
	
		<div class="container">
			
			<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis consequuntur dolore, ullam obcaecati.<br> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

			<div class="col-sm-6">

				<div class="form-cad">

					@if( $errors->has('erro') ) 
						<div class="alert alert-danger alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							Não foi possível enviar seu email, por favor confira os dados e tente mais tarde.
						</div>
					@endif

					@if( session('success') ) 
						<div class="alert alert-success alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							Nossa equipe já recebeu o seu contato e em breve o retornaremos. <br><strong>Muito Obrigado!</strong> 
						</div>
					@endif

					<form method="POST" action="contato" accept-charset="UTF-8">
			    		
			    		<input name="_token" type="hidden" value="{{ Session::token() }}">
						<input name="form" type="hidden" value="contato">
				      	
				      	<div class="row">

				      		<div class="col-sm-6">
						      	
						      	<div class="form-group @if ($errors->has('nome')) has-error @endif">			      		
						            <input id="nome" class="form-control"  name="nome" type="text" placeholder="Nome" value="{{ old('nome')}}" >
									@if ($errors->has('nome')) <span class="help-block">O campo "Nome" é obrigatório</span> @endif
						        </div>

						    </div>

						    <div class="col-sm-6">
						      	
						      	<div class="form-group @if ($errors->has('telefone')) has-error @endif">			      		
						            <input id="telefone" class="form-control"  name="telefone" type="text" placeholder="Telefone" value="{{ old('telefone')}}" >
									@if ($errors->has('telefone')) <span class="help-block">O campo "Telefone" é obrigatório</span> @endif
						        </div>

						    </div>

					    </div>

					    <div class="row">

				      		<div class="col-sm-12">
						      	
						      	<div class="form-group @if ($errors->has('email')) has-error @endif">
						            <input id="email" class="form-control"  name="email" type="email" placeholder="E-mail" value="{{ old('email') }}" >
									@if ($errors->has('email')) {!! $errors->first('email', '<span class="help-block">:message</span>') !!} @endif
						        </div>

						    </div>

						</div>

						<div class="row">

				      		<div class="col-sm-12">
						      	
						      	<div class="form-group @if ($errors->has('mensagem')) has-error @endif">				      		
						            <textarea id="mensagem" class="form-control"  name="mensagem" placeholder="Mensagem"  >{{ old('mensagem')}}</textarea>
									@if ($errors->has('mensagem')) <span class="help-block">Este campo é obrigatório!</span> @endif
						        </div>

						    </div>

						</div>

				        <div class="form-group">
				            <input class="btn btn-lg btn-blue" value="Enviar" type="submit">
				        </div>

				    </form>

				</div>

			</div>

			<div class="col-sm-5">

				<div class="contact-info">
					<div class="itens">
						<div class="col-xs-12 item">
							<div class="col-xs-1 text-center">
								<i class="fa fa-map-marker" aria-hidden="true"></i>
							</div>
							<div class="col-xs-10">
								{{ $info['loja']->logradouro }},
								{{ $info['loja']->numero }} -
								{{ $info['loja']->bairro }} -
								{{ $info['loja']->cidade }} -
								{{ $info['loja']->estado }}
							</div>
						</div>

						<div class="col-xs-12 item">
							<div class="col-xs-1 text-center">
								<i class="fa fa-phone" aria-hidden="true"></i>
							</div>
							<div class="col-xs-10">
								{{ $info['loja']->telefone }}
							</div>
						</div>

						<div class="col-xs-12 item">
							<div class="col-xs-1 text-center">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
							<div class="col-xs-10">
								{{ $info['loja']->email }}
							</div>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="col-xs-12 item item-social text-center">
						<a href="#"> <i class="fa fa-facebook-official" aria-hidden="true"></i> </a>
						<a href="#"> <i class="fa fa-instagram" aria-hidden="true"></i> </a>
					</div>

					<div class="clearfix"></div>
					
				</div>
				
			</div>

		</div>	

	</section>

	<div id="map" class="map">
	</div>


@endsection


@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFGpdO1fqa5ksgwMxDrefy1msxh3BfyBU&callback=initMap"
    async defer></script>

    <script>

    	$(window).load(function() {
		    initMap();
		})

    	function initMap() 
		{
		    // Create a map object and specify the DOM element for display.
		    var latitude = {lat: -23.6265361, lng: -46.5594959 };
		    var map = new google.maps.Map(document.getElementById('map'), {
		      center: latitude,
		      scrollwheel: false,
		      zoom: 15
		    });

		    var marker = new google.maps.Marker({
		        position: latitude,
		        map: map,
		        title: 'Multiplay'
		    });

		}

    </script>
@endsection