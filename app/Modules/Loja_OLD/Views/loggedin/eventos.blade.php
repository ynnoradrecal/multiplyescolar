@extends('Loja::master')

@section('title', 'Eventos')

@section('css')

	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.block-grid/latest/bootstrap3-block-grid.min.css" />

@endsection

@section('content')

	<section id="breadcrumb">

		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">
		
		<div class="container">

			<div class="col-md-5">

				<h1>Eventos</h1>

			</div>

			<div class="col-md-2 text-center">
					<i class="fa fa-folder-open" aria-hidden="true"></i>
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

	<section id="breadcrumb-compra">

		<div class="container">

			<div class="row">

				<ul>

					<div class="col-md-6 col-sm-6 col-xs-9 col-xs-offset-1 col-md-offset-0">
						<li class="active"><span>1</span> Eventos </li>
						<li><span>2</span> Galerias </li>
						<li><span>3</span> Fotos </li>
					</div>

					<div class="col-md-6 col-sm-6 col-xs-9 col-xs-offset-1 col-md-offset-0">
						<li><span>4</span> Opções </li>
						<li><span>5</span> Entrega </li>
						<li><span>6</span> Pagamento </li>
					</div>

				</ul>

			</div>

		</div>

	</section>

	<section id="eventos">

		<div class="container">

			<div class="block-grid-xs-1 block-grid-sm-2 block-grid-md-3">

				@foreach ($eventos as $evento)
				
					<div class="">

						<div class="grid-container">

							<div class="grid">

								<img src="{{ asset($evento['capa'][0]['path'].'/'.$evento['capa'][0]['capa']) }}" class="img-responsive" alt="" />

								<div class="mask">

									<h3>{{ $evento['name'] }}</h3>
									<!-- Limita exibição de 88 caracteres do conteúdo -->
									<p>{!! str_limit($evento['description'], 88) !!}</p>
									<a href="eventos/{{ $evento['id'] }}" class="btn btn-blue">Acessar</a>

								</div>

							</div>

							<h3 class="text-center">{{ $evento['name'] }}</h3>

						</div>

					</div>

				@endforeach

			</div>

		</div>

	</section>

@endsection

@section('script')
	<script type="text/javascript">

		$('a.back').click(function(){
			parent.history.back();
			return false;
		});
	
	</script>
@endsection
