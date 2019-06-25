<section id="clientes">

		<div class="container">

			<div class="col-md-4">

                <div class="sidebar">

                    <header class="">

						<div class="row">

							<div class="col-sm-5 col-xs-12 text-center">

								<div class="image-profile">

									<a href="#">
										<i class="fa fa-user" aria-hidden="true"></i>
									</a>

								</div>

							</div>

							<div class="col-sm-7 col-xs-12 text-center">

								<h3>
									<span>Olá,</span> {{ auth()->guard('cliente')->user()->name }} 
								</h3>
								<a href="{{ route('logout.cliente') }}">Sair</a>

							</div>

						</div>

                    </header>

					<nav id="client-data">
						
						<ul>
							<li><a href="{{ url('/beta/minha-conta/'. auth()->guard('cliente')->user()->id .'/pedidos') }}">
								<i class="fa fa-cubes"></i> Meus Pedidos
							</a></li>
							<li><a href="{{ route('show.dados.cliente') }}">
								<i class="fa fa-folder-open"></i> Dados Cadastrais
							</a></li>
							<li><a href="{{ url('/beta/minha-conta/'. auth()->guard('cliente')->user()->id .'/enderecos') }}">
								<i class="fa fa-map-marker"></i> Meus Endereços
							</a></li>
							<li><a href="{{ url('/beta/minha-conta/atendimento') }}">
								<i class="fa fa-pencil-square-o"></i> Atendimento
							</a></li>
						</ul>

					</nav>

                </div>

            </div>

            <div class="col-md-8">

                <div class="content">
                </div>

            </div>

		</div>