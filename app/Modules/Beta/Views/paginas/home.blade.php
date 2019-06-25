
@extends('Beta::master')

@section('title', 'Home Page')

@section('content')
  <?php $info = session()->get('lojaInfo'); ?>
	<section id="sec-1">

		<div id="como-funciona" class="container">
			
			<div class="col-sm-4 col-md-offset-4 section-text-content">
				<h3 class="text-center">COMO FUNCIONA</h3>
			</div>
			<div class="clearfix"></div>
			
			<div class="col-md-10 col-md-offset-1">

				<div class="col-md-4">
					<div class="item-destaque text-center">
						<img src="{{ url('images') }}/icon-mobile.png" class="center-block" />
						<h4>Passo 1</h4>
						<h3>CADASTRE-SE</h3>
						<p>Precisamos conhecer você, <br>é simples e fácil.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="item-destaque text-center">
						<img src="{{ url('images') }}/icon-image.png" class="center-block" />
						<h4>Passo 2</h4>
						<h3>ESCOLHA AS MEMÓRIAS</h3>
						<p>Selecione as melhores fotos que<br> gostaria de receber.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="item-destaque text-center">
						<img src="{{ url('images') }}/icon-galeria.png" class="center-block" />
						<h4>Passo 3</h4>
						<h3>RECEBA SUAS EMOÇÕES</h3>
						<p>Receba as suas fotos e eternize<br> todos os momentos!</p>
					</div>
				</div>

				
			</div>			

		</div>

	</section>

	<section id="sec-2">

		<div id="sobre-nos" class="container">

			{{-- <div class="col-sm-4 col-md-offset-4 text-center">
				<div class="header text-center">
					<h2>SOBRE NÓS</h2>
				</div>
			</div>
			<div class="clearfix"></div> --}}

			<div class="col-md-5">

				<h3>SOBRE NÓS</h3>
				<p>Fundada em São Caetano do Sul 19XX, com uma forma inovadora e pioneira de trabalhar em escolas, a Multiply abriu novas frentes através dos anos, até chegar na atual estrutura de empresa que compõe, 5 divisões especializadas em mercados diferentes da fotografia em um estúdio de 400m².</p>
				<ul class="check-list">
					<li>Casamento</li>
					<li>Empresas</li>
					<li>Escolas</li>
					<li>Debutante</li>
					<li>Books</li>
				</ul>
				<p>Já são mais de XXXX histórias eternizadas pela multiply.<br>
				Venha eternizar seus momentos e permita-nos fazer parte de sua história.</p>
			</div>

			<div class="col-md-7 text-center">

				<div class="slide-multiply-images">

					<div class="single-item">

						@for($i = 1; $i <= 3; $i++)

							<div class="section-text-content">

								<figure>

									<img src="{{ asset('images') }}/image-multiply-{{ $i }}.png" class="img-responsive center-block" />
								
								</figure>

							</div>

						@endfor

					</div>

				</div>

			</div>

			{{-- <div class="col-sm-3 text-center">

				<img src="{{ asset('images') }}/rapido-icon.png" alt="Rápido" class="center-block">

				<h3 class="text-center">RÁPIDO</h3>

				<p class="text-center">De forma rápida você seleciona as fotos e configurações especiais e em poucos dias já tem em mãos seu álbum.</p>

			</div>

			<div class="col-sm-3 text-center">

				<img src="{{ asset('images') }}/album-icon.png" alt="Flexível" class="center-block">

				<h3 class="text-center">FLEXÍVEL</h3>

				<p class="text-center">Altamente configurável, temos diversas opções para melhor guardar as recordações, selecione cada foto, formato, capa, tecido e forma de entrega.</p>

			</div> --}}

		</div>

	</section>

	<section id="sec-3">	

		<div id="contato" class="col-sm-5 left">

			<div class="col-sm-8 col-md-offset-2">

				<div class="endereco">

					<img src="{{ asset('images') }}/logo-black.png" class="center-block" />
					<p class="text-center logradouro">
						{{ $info['loja']->logradouro }}, 
						{{ $info['loja']->numero }} 
						{{ ($info['loja']->complemento != '') ? ' - '.$info['loja']->complemento : '' }} -
						{{ $info['loja']->bairro }} <br>{{ $info['loja']->cidade }} - {{ $info['loja']->estado }}</p>
		
					<div class="col-sm-8 col-sm-offset-2 phone-box">
						<div class="row">
						<div class="col-xs-2 text-right">
							<i class="fa fa-phone" aria-hidden="true"></i>
						</div>
						<div class="col-xs-8 text-left">
							<span class="phone-number">{{ $info['loja']->telefone }}</span>
						</div>
						</div>
					</div>
		
					<p class="email text-center">
						<a href="mailto:{{ $info['loja']->email }}">{{ $info['loja']->email }}</a>
					</p>
		
					<div class="col-xs-12 item-social text-center">
						<a href="#"> <i class="fa fa-facebook-official" aria-hidden="true"></i> </a>
						<a href="#"> <i class="fa fa-instagram" aria-hidden="true"></i> </a>
					</div>

				</div>

			</div>

		</div>

		<div class="col-sm-7 right">

			<div class="col-md-9">

				<div class="form-home">
					<h2>FALE COM A GENTE</h2>
					<form id="homeForm" method="POST" action="contato" accept-charset="UTF-8">
							
						<input name="_token" type="hidden" value="{{ Session::token() }}">
						<input name="form" type="hidden" value="contato">
						
						<div class="row">

							<div class="col-sm-6">
								
								<div class="form-group @if ($errors->has('nome')) has-error @endif">
									<lable for="nome">Nome</lable>		      		
									<input id="nome" class="form-control"  name="nome" type="text" placeholder="" value="{{ old('nome')}}" >
									@if ($errors->has('nome')) <span class="help-block">O campo "Nome" é obrigatório</span> @endif
								</div>

							</div>

							<div class="col-sm-6">
								
								<div class="form-group @if ($errors->has('email')) has-error @endif">
									<lable for="email">Email</lable>
									<input id="email" class="form-control"  name="email" type="email" placeholder="" value="{{ old('email') }}" >
									@if ($errors->has('email')) {!! $errors->first('email', '<span class="help-block">:message</span>') !!} @endif
								</div>

							</div>

							{{--  <div class="col-sm-6">
								
								<div class="form-group @if ($errors->has('telefone')) has-error @endif">			      		
									<input id="telefone" class="form-control"  name="telefone" type="text" placeholder="Telefone" value="{{ old('telefone')}}" >
									@if ($errors->has('telefone')) <span class="help-block">O campo "Telefone" é obrigatório</span> @endif
								</div>

							</div>  --}}

						</div>

						<div class="row">

							<div class="col-sm-12">
								
								<div class="form-group @if ($errors->has('mensagem')) has-error @endif">
									<lable for="mensagem">Mensagem</lable>			      		
									<textarea id="mensagem" class="form-control"  name="mensagem" placeholder=""  >{{ old('mensagem')}}</textarea>
									@if ($errors->has('mensagem')) <span class="help-block">Este campo é obrigatório!</span> @endif
								</div>

							</div>

						</div>

						<div class="form-group">
							<input id="senderButton" class="btn btn-lg btn-blue pull-right" value="Enviar" type="submit">
							<a id="buttonFake" class="btn btn-lg btn-blue pull-right" style="display: none">Enviando...</a>
						</div>

					</form>
				</div>
			</div>

		</div>
		<div class="clearfix"></div>

	</section>
	
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		$('.single-item').slick();
	})
</script>
@endsection
