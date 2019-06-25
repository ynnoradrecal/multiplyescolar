@extends('Loja::master')

@section('title', 'Tipo de Produto')

@section('css')
	
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css" />
	<link rel="stylesheet" href="{{ asset("css") }}/slick-theme.css" />
	<style>

		.container-radio .radio{
			width: 20px;
			height: 20px;
			background: #ccc !important;
			border: solid 2px #f02;
		}

		.container-radio{
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.container-radio li{
			display: inline-block;
		}

		.container-radio li label{
			font-size: 22px;
			margin-left: 12px;
		}

		.slick-dots li button::before{
			font-size: 40px !important;
		}

	</style>

@endsection

   
@section('content')

	<section id="breadcrumb">

		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">

		<div class="container">

			<div class="col-md-5">

				<h1>Opções</h1>

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
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Galerias 
					</li>
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Fotos 
					</li>
					<li class="active"><span>4</span> Formato </li>
					<li><span>5</span> Opções </li>
					<li><span>6</span> Entrega </li>
					<li><span>7</span> Pagamento </li>
				</div>
			</ul>

		</div>

	</section>

	<section id="tipo-produto">

		<div class="container">

			<div class="col-md-10 col-md-offset-1">

				<div class="row">

					<div class="col-md-12">
						<h1>Escolha o tipo de produto</h1>
					</div>

					{{--  <div class="col-md-6">

						<article class="tipo-container">
							<figure>
								<img src="{{ asset('images/') }}/arquivo-digital.jpg" class="img-responsive" />	
							</figure>
							<h3>Receber Arquivo  Digital</h3>
							<p>Você receberá um link para download (das imagens em alta resolução), assim que o pagamento for confirmado.</p>
							<br>
							<a href="{{ url('/') }}/midia-digital/{{ $util->produto_id }}">Prosseguir</a>
							<br /><br /><br /><br />
						</article>

					</div>  --}}

					<div class="col-md-6">

						<article class="tipo-container">
							<figure>
								<img src="{{ asset('images/') }}/arquivo-impresso.jpg" class="img-responsive" />		
							</figure>
							<h3>Produto Impresso</h3>
							<p>Você receberá um impresso em formato e tamanho escolhidos nos próximos passos.</p>
							<br>
							<a href="{{ url('opcoes') }}/{{ $util->produto_id }}">Prosseguir</a>
							<br /><br />
						</article>

					</div>

				</div>

			</div>
		</div>
	</section>
@endsection