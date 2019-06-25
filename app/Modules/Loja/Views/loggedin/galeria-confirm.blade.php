@extends('Loja::master')

@section('title', 'Confirmar Fotos')

@section('css')
	
	<style type="text/css" media="screen">
		
		#galeria button { outline:none; }

		#galeria .header .jumbotron a { padding: 0; }

		#galeria .header div > a { padding:13px 32px 10px; }
		#galeria .footer > div { position:relative;right:2px; }
		#galeria .footer div > a { padding:13px 32px 10px; }

		#zoof .modal-body { position:relative; }
		#zoof .modal-body .nav-controll { position:absolute;top:44%; }
		#zoof .modal-body .nav-controll button { position:absolute;top:0;padding:12px 18px; }
		#zoof .modal-body .nav-controll .prev { left: 6px; }
		#zoof .modal-body .nav-controll .next { right: 38px; }


	</style>

@endsection
  
@section('content')

	<section id="breadcrumb">
		
		<div class="container">

			<div class="col-xs-12 text-center">

				<i class="fa fa-picture-o fa-2x"></i>
				<h1>FOTOS</h1>
				<small><b>Home</b> / Confirmar / Fotos</small>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">

	</section>

	@include('Loja::templates.steps')

	<section id="galeria">
		<div class="container">

			<div class="header row clearfix">

				<div class="col-xs-12">
					<div class="jumbotron" style="margin-bottom:5px;">

						<h1>{{ $nome_do_evento }}</h1>
						<h2>{{ $nome_da_galeria }}</h2>
						
						<br>

						<div class="col-md-6 col-xs-6 text-left">
							<a href="{{ url('/') }}/galerias/id/{{ $id_galeria }}"><i class="fa fa-reply"></i> SEÇÃO ANTERIOR</a>
						</div>

						<!-- <div class="col-md-6 col-xs-6 text-right">
							<a href="{{ route('confirm-photos') }}">PRÓXIMO SEÇÃO <i class="fa fa-share"></i></a>
						</div> -->

					</div>
					
				</div>

			</div>

			<br/>
			
			<div class="row">
				<div class="col-xs-12 text-center cart-clean" style="display:none;padding:100px 0px 160px;">

					<h1>SEU CARRINHO NÃO POSSUI FOTO!</h1>
					<p>Clique no botão a baixo para voltar a galeria de fotos</p>
					<a href="{{ url('/') }}/galerias/{{ $id_galeria }}" class="btn btn-default">
						<span class="glyphicon glyphicon-picture" aria-hidden="true"></span> GALERIA
					</a>

				</div>
			</div>

			<article class="row galeria clearfix">

				@if( count($data) > 1 )
		            @foreach( $data as $item )
		            <div class="col-sm-6 col-md-3 col-xs-12"> 
		                <div class="thumbnail text-center" ref="{{ $item['id'] }}" style="position:relative;"> 
		                    
		                    <div class="btn-success btn-xs text-center tag" 
		                        style="position:absolute;top:12px;left:50%;margin-left:-60px;padding:0 26px;display:none;">
		                        <small>SELECIONADA</small>
		                    </div>

		                    <img src="{{ $item['foto'] }}" alt="">
		                    
		                    <div class="caption"> 

		                        <button class="btn btn-success addf" role="button" data-toggle="tooltip" data-placement="left" title="SELECIONAR">
		                            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
		                        </button>

		                        <button class="btn btn-danger delf" role="button" style="display:none;" data-toggle="tooltip" data-placement="left" title="REMOVER">
		                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		                        </button>

		                        <button class="btn btn-primary comf" role="button" data-toggle="modal" data-target="#comf" data-placement="bottom" title="COMENTÁRIO">
		                            <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
		                        </button>

		                        <button class="btn btn-primary zoof" role="button" data-toggle="modal" data-target="#zoof" data-placement="right" title="ZOOM">
		                            <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
		                        </button>

		                    </div> 
		                </div>
		            </div> 
		            @endforeach
		        @endif

			</article>

			<div class="footer row">
				
	    		<div class="col-xs-12 text-right">
	    			<div class="col-xs-12 text-right" >
	    				<a href="{{ url('/') }}/galerias/id/{{ $id_galeria }}" class="btn btn-default">
	    					<span class="glyphicon glyphicon-picture" aria-hidden="true"></span> GALERIA
	    				</a>
	    				<a class="btn btn-primary" href="{{ url('/') }}/settings-cart">
	    					PRÓXIMO SEÇÃO&nbsp;&nbsp;<i class="fa fa-share"></i>
	    				</a>
	    			</div>
		        </div>

		        <br><br><br>

		        <div class="col-xs-12 text-center clearfix">
		        	<h4 style="color:#337ab7;">
		        		<span class="total-fotov">0</span> FOTOS SELECIONADAS
		        	</h4>
		        </div>

			</div>

			<!-- modal -->
			<div class="row">
				<div class="col-xs-12">
					<div class="modal fade" id="comf" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-body">
									<form class="clearfix">
										<div class="form-group">
											<div class="col-xs-12 text-center">
												<h4 class="control-label">ADICIONAR COMENTÁRIO</h4>
												<p>Deixe uma observação ou instrução sobre esta foto.</p>
											</div>
											<textarea class="form-control comment" id="message-text" rows="10"></textarea>
										</div>

										<div id="error" class="alert" role="alert" style="margin:0;display:none;">  
										</div>

									</form>
								</div>
								<div class="col-xs-12 text-center">
									<button style="margin-top:10px;" type="button" class="btn btn-default" data-dismiss="modal">
										<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> SAIR
									</button>
									<button style="margin-top:10px;" type="button" class="btn btn-primary addc">
										SALVAR COMENTÁRIO
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12">
					<div class="modal fade" id="zoof" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-body">
									<img src="" alt="" width="100%">
									<input type="hidden" name="id" value="">
								</div>
								<div class="col-xs-12 text-center modal-button">
									<button style="margin-top:10px;" type="button" class="btn btn-default" data-dismiss="modal">
										<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> SAIR
									</button>
									<button style="margin-top:10px;" type="button" class="btn btn-success addf">
										<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> SELECIONAR
									</button>
									<button style="margin-top:10px;display:none;" type="button" class="btn btn-danger delf">
										<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> REMOVER
									</button>
								</div>
							</div>
							<br/><br/>
						</div>
					</div>
				</div>
			</div>

		</div>
  	</section>


@endsection



