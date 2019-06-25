@extends('Loja::master')

@section('title', 'Eventos')

@section('css')

	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.block-grid/latest/bootstrap3-block-grid.min.css" />

@endsection

@section('content')


	<section id="breadcrumb">
		
		<div class="container">

			<div class="col-xs-12 text-center">

				<i class="fa fa-glass" aria-hidden="true"></i>
				<h1>EVENTOS</h1>
				<small><b>Home</b> / Eventos</small>

			</div>

		</div>

	</section>

	@include('Loja::templates.steps')

	<section id="eventos">

		<div class="container">
			
			<div class="row">
				
				@foreach ($eventos as $evento)
				<div class="col-sm-6 col-md-4">
					<div class="thumbnail">
						
						@php 

							$base = $evento['capa'][0]['path'];
							$capa = $evento['capa'][0]['capa'];
							
							$image = $base .'/'. $capa;
							
							//http://via.placeholder.com/350x250

						@endphp 
						
						<figure class="thumbnail" style="border:1px solid #ccc;overflow:hidden;margin-bottom:0;">
							<img src="{{ asset($image) }}" alt="..." style="width:100%;height:240px;">
						</figure>

						<div class="caption text-center">
							<h3 style="margin-top:0;">{{ $evento['name'] }}</h3>
							<p>{!! str_limit($evento['description'], 88) !!}</p>
							<p>
								<a href="{{ url('/eventos/id') .'/'. $evento['id'] }}" class="btn btn-primary" role="button">
									<i class="fa fa-sign-in"></i> ENTRAR
								</a>
							</p>
						</div>
					</div>
				</div>
				@endforeach

			</div>

		</div>

	</section>

@endsection


