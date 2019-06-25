<header>
	
@php 
	$base = Request::url();
@endphp 
		

<!-- <div class="container-fluid navbar" style="padding:0;margin-top:24px;"> -->
@if( $base == url('/') || $base == url('/home') )
	<div class="container-fluid navbar navbar-fixed-top" style="padding:0;margin-top:24px;">
@else
	<div class="container-fluid navbar content-top" style="padding:0;margin-top:24px;">
@endif
		<div class="container">

			<div class="logo col-md-4 col-sm-5  col-xs-12">

				<a href="{{ url('/') }}">
					@if( $base == url('/') || $base == url('/home') )
						<img src="{{ asset('images') }}/logo-multiply.png" class="img-responsive center-block" alt="Logo Multiply Escolar">
					@else
						<img src="{{ asset('images') }}/logo-black.png" class="img-responsive center-block" alt="Logo Multiply Escolar">
					@endif
				</a>

			</div>

			<div class="top-icons col-md-8 col-sm-7 col-xs-12">

				<nav class="top-bar text-center">

					<ul>
						<li class="link-menu hidden-xs"><a class="checkCart" href="{{ url('/home') }}">HOME</a></li>
						<li class="link-menu hidden-xs"><a class="checkCart" href="{{ url('/home#como-funciona') }}" link="como-funciona" >COMO FUNCIONA?</a></li>
						<li class="link-menu hidden-xs"><a class="checkCart" href="{{ url('/home#sobre-nos') }}" link="sobre-nos" >SOBRE NÓS</a></li>
						<li class="link-menu hidden-xs"><a class="checkCart" href="{{ url('/home#contato') }}" link="contato" >CONTATO</a></li>

						<li class="eventos-menu hidden-xs text-center">
							<a href="{{ url('beta/eventos')}}" class="btn btn-evento btn-next checkCart">VEJA SUAS FOTOS</a><br>

							@if (Auth::guard('cliente')->check())
							<p>Olá, {{ Auth::guard('cliente')->user()->name }} {{ Auth::guard('cliente')->user()->last_name }}. &nbsp;<a class="cadastro" href="{{ route('logout.cliente') }}">Sair</a></p>
							@else
							<p>Ainda não é cadastrado? <a class="cadastro" href="{{ url('/login-cadastro#cadastro')}}">Cadastre-se</a></p>
							@endif

						</li>

						<li id="top-user">

							<a href="#">

								<i class="fa fa-user"></i>

							</a>

							<div class="sub-menu">

								<img src="{{ asset('images') }}/sub-menu-seta.png" class="center-block" alt="Multiply Escolar">

								<ul class="text-center">

									@if (Auth::guard('cliente')->check())
									<li>
										<a class="cadastro" href="{{ route('logout.cliente') }}">Sair</a>
									</li>
									@else
									<li>
										<a class="main-cadastro" href="{{ url("/login-cadastro#cadastro") }}">Cadastre-se</a>
									</li>
									<li>
										<a href="{{ url("/login-cadastro") }}">Entrar</a>
									</li>
									@endif


									<li>
										<a href="{{ url("/minha-conta") }}" class="checkCart">Minha conta</a>
									</li>
								</ul>
							</div>

						</li>

						<li id="top-cart">

							<a href="#">
								<i class="fa fa-shopping-cart"></i>
								@if (Session::has('cart'))
								<?php 

								$cart = Session::get("cart");
								$politicas = count($cart->politicas);
								$imagens = count($cart->imagens);

								?>
								<span class="cart-badge label label-danger">{{ $imagens + $politicas }}</span>
								@endif
								
								
							</a>


						</li>

						<li id="top-menu">

							{{-- <a href="javascript:void(0)" type="button" class="hamburger is-closed" data-toggle="offcanvas">
								<span class="hamb-top"></span>
								<span class="hamb-middle"></span>
								<span class="hamb-bottom"></span>
							</a> --}}

						</li>

					</ul>

					<ul class="menu-mobile">
						<li class="eventos-menu visible-xs text-center">
							<a  href="{{ url('/eventos')}}" class="btn btn-evento btn-next checkCart">VEJA SUAS FOTOS</a><br>

							@if (Auth::guard('cliente')->check())
							<p>Olá, {{ Auth::guard('cliente')->user()->name }} {{ Auth::guard('cliente')->user()->last_name }}. &nbsp;<a class="cadastro" href="{{ route('logout.cliente') }}">Sair</a></p>
							@else
							<p>Ainda não é cadastrado? <a class="cadastro" href="{{ url('/login-cadastro#cadastro')}}">Cadastre-se</a></p>
							@endif

						</li>
						<li class="link-menu visible-xs"><a class="checkCart" href="{{ url('/') }}">HOME</a></li>							
						<li class="link-menu visible-xs"><a class="checkCart" href="{{ url('/home#como-funciona') }}" link="como-funciona" >COMO FUNCIONA?</a></li>
						<li class="link-menu visible-xs"><a class="checkCart" href="{{ url('/home#sobre-nos') }}" link="sobre-nos" >SOBRE NÓS</a></li>
						<li class="link-menu visible-xs"><a class="checkCart" href="{{ url('/home#contato') }}" link="contato" >CONTATO</a></li>
					</ul>

				</nav>

				<div class="clearfix"></div>

			</div>

		</div>

	</div>

@if ( Request::url() == url('/home') || Request::url() == url('/') )

	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="{{ asset('images')}}/banner-home-1.jpg" alt="...">
				{{-- <div class="carousel-caption">
					...
				</div> --}}
			</div>
			<div class="item">
				<img src="{{ asset('images')}}/banner-home-2.jpg" alt="...">
				{{-- <div class="carousel-caption">
					...
				</div> --}}
			</div>
			<div class="item">
				<img src="{{ asset('images')}}/banner-home-3.jpg" alt="...">
				{{-- <div class="carousel-caption">
					...
				</div> --}}
			</div>
		</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

@endif

</header>



