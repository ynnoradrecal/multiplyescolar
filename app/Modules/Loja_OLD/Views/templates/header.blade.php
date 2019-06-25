
	<header>

		@if ( Request::url() == url('/home') || Request::url() == url('/') )
			<?php $class = ''; ?>
		@else
			<?php $class = 'content-top'; ?>
		@endif

		<div class="container-fluid  <?php echo $class; ?> navbar navbar-fixed-top">

			<div class="container">
				
				<div class="logo col-md-4 col-sm-5  col-xs-12">
					<a href="{{ url('/') }}">
						<img src="{{ asset('images') }}/logo-multiply.png"  class="img-responsive center-block" alt="Logo Multiply Escolar">
					</a>
				</div>

				<div class="top-icons col-md-8 col-sm-7 col-xs-12">

					<nav class="top-bar text-center">

						<ul>
							<li class="link-menu hidden-xs"><a href="{{ url('/') }}">HOME</a></li>
							<li class="link-menu hidden-xs"><a href="#" link="como-funciona" >COMO FUNCIONA?</a></li>
							<li class="link-menu hidden-xs"><a href="#" link="sobre-nos" >SOBRE NÓS</a></li>
							<li class="link-menu hidden-xs"><a href="#" link="contato" >CONTATO</a></li>
							
							<li class="eventos-menu hidden-xs text-center">
								<a href="{{ url('/eventos')}}" class="btn btn-evento btn-next">VEJA SUAS FOTOS</a><br>

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
											<a href="{{ url("/minha-conta") }}">Minha conta</a>
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

								<div class="sub-menu">

									<img src="{{ asset('images') }}/sub-menu-seta.png" class="center-block" alt="Multiply Escolar">
									<ul class="">
									
											@if (Session::has('cart'))
												<?php $cart = Session::get("cart");  ?>

												<li>
													<p>Imagens: <span class="badge label label-danger">{{ count($cart->imagens) }}</span>
													<span class="cart-price">R$ {{ number_format((count($cart->imagens) * $cart->precoUnidadeImagem),2,",",".") }}</span>
													</p>
												</li>

												@if( count($cart->politicas) > 0 )
													<?php $titulo = ''; $politicasSubTot = 0; ?>
													<li class="politica text-left">
														
														@for( $i = 0; $i < count($cart->politicas); $i++)
															<?php $titulo .= $cart->politicas[$i]['titulo']. '<br>'; ?>
															<?php $politicasSubTot += $cart->politicas[$i]['preco']; ?>															
														@endfor
														<p>
															<span class="main-title">Opcionais</span>
															<span class="title">{!! $titulo !!}</span>
															<span class="cart-price">R$ {{ number_format($politicasSubTot, 2,",",".") }} </span>
														</p>
													</li>
												@endif
												<li class="price">
													<p>
														<span class="title">Valor Total (sem frete)</span> 
														<span class="cart-price">R$ {{ number_format($cart->precoTotal, 2,",",".") }} </span>
													</p>
												</li>
											@else
												<li>
													<p><a>Carrinho Vazio</a></p>
												</li>
											@endif
										
									</ul>
								</div>

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
								<a href="{{ url('/eventos')}}" class="btn btn-evento btn-next">VEJA SUAS FOTOS</a><br>

								@if (Auth::guard('cliente')->check())
									<p>Olá, {{ Auth::guard('cliente')->user()->name }} {{ Auth::guard('cliente')->user()->last_name }}. &nbsp;<a class="cadastro" href="{{ route('logout.cliente') }}">Sair</a></p>
								@else
									<p>Ainda não é cadastrado? <a class="cadastro" href="{{ url('/login-cadastro#cadastro')}}">Cadastre-se</a></p>
								@endif
								
							</li>
							<li class="link-menu visible-xs"><a href="{{ url('/') }}">HOME</a></li>							
							<li class="link-menu visible-xs"><a href="#" link="como-funciona" >COMO FUNCIONA?</a></li>
							<li class="link-menu visible-xs"><a href="#" link="sobre-nos" >SOBRE NÓS</a></li>
							<li class="link-menu visible-xs"><a href="#" link="contato" >CONTATO</a></li>
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

			{{-- <div class="container-fluid banner">

				<div class="container">

					<div class="col-md-8 col-md-offset-2">

						<div class="banner-content">

							<a href="{{ url('/') }}">
								<img src="{{ asset('images') }}/white-logo.png" class="img-responsive center-block" />
							</a>

							<br>

							<h1 class="text-center">ETERNIZE MOMENTOS ESPECIAIS</h1>

							<p class="text-center">
								Com 10 anos de experiência em fotos escolares, desde um simples dia de aula a formaturas inesquecíveis. Eternize esses momentos especiais, aqui respiramos arte.
							</p>

						</div>

					</div>

				</div>

			</div> --}}

		@endif


	</header>



	{{--  <div id="wrapper">
		<div class="overlay"></div>

		<!-- Sidebar -->
		<div class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
			<img src="{{ asset('images') }}/menu-top.png" alt="Multiply Escolar" class="img-responsive">
			<br>

			<ul class="nav sidebar-nav">

				<li class="sidebar-brand">
					<br>
					<a href="{{ url('/') }}">
						<img src="{{ asset('images') }}/logo.png" alt="Logo Multiply Escolar" class="img-responsive">
					</a>
				</li>
				
				<li>
					<a href="{{ url('/') }}">Home</a>
				</li>

				<li>
					<a href="#">Quem Somos</a>
				</li>

				<li>
					<a href="{{ url('/eventos') }}">Eventos</a>
				</li>

				<li>
					<a href="{{ url('/login-cadastro') }}">Login/Cadastro</a>
				</li>

				<li>
					<a href="{{ url('/contato') }}">Contato</a>
				</li>

				<li class="nav-foot">
					<div class="line line-phone">
						<span class="icon pull-left"><i class="fa fa-phone" aria-hidden="true"></i></span>
						<span class="content pull-left">+55 11 2376-2905</span>
						<span class="clearfix"></span>
					</div>
					<br>

					<div class="line line-email">
						<span class="icon pull-left"><i class="fa fa-envelope" aria-hidden="true"></i></span>
						<span class="content pull-left">atendimento@multiply.art.br</span>
						<span class="clearfix"></span>
					</div>
					<br>

					<div class="line line-social text-center">
						<a href="#" class="pull-left">
							<i class="fa fa-facebook-official" aria-hidden="true"></i>
						</a>
						<a href="#" class="pull-left">
							<i class="fa fa-instagram" aria-hidden="true"></i>
						</a>
					</div>

				</li>



			</ul>

		</div>
		<!-- /#sidebar-wrapper -->
	</div>  --}}





		{{-- <nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Project name</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">

			<ul class="nav navbar-nav">
				<li class=""><a href="{{ url('/') }}">Home</a></li>
				<li><a href="#"  data-toggle="modal" data-target="#modalLogin">Login</a></li>
				<li><a href="#" data-toggle="modal" data-target="#modalCadastro">Cadastro</a></li>
				<li><a href="{{ url('/') }}/cliente/1/endereco">Lista de Endereços</a></li>
			</ul>

			</div><!--/.nav-collapse -->
		</div>
		</nav>
	--}}
