@extends('Loja::master')
@section('title', 'Homologação')
@section('content')

	<section id="breadcrumb">
		
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines" />
		
		<div class="container">

			<div class="col-md-5">

				<h1>{{ $title }} <!-- <small style="color:#fff;">Apresentação Coral</small> --></h1> 
			</div>

			<div class="col-md-2 text-center">

				<i class="fa fa-folder-open" aria-hidden="true"></i>

			</div>

			<div class="col-md-5 text-right">

				<ul>
					<li>Home</li>
					<li>/</li>
					<li>{{ $title }}</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">

	</section>
	
	<br/><br/>

	<section id="galnew">
		<div class="container">
			
			<div class="header row clearfix">
		        <div class="col-xs-12 text-right">
		        	<button class="btn btn-default redirect" redirect="{{ url('/') }}/homologacao" role="button">
		        		<span class="glyphicon glyphicon-picture" aria-hidden="true"></span> GALERIA
		        	</button>
	                <button class="btn btn-primary redirect" redirect="{{ url('/') }}/photos-validate" role="button">
	                    PRÓXIMO <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	                </button>
	            </div>
		    </div>
			
			<br/><br/>

			<div class="row">
				<div class="col-xs-12 text-center cart-clean" style="display:none;padding:100px 0px 160px;">

					<h1>SEU CARRINHO NÃO POSSUI FOTO!</h1>
					<p>Clique no botão a baixo para voltar a galeria de fotos</p>
					<button class="btn btn-default redirect" redirect="{{ url('/') }}/homologacao" role="button">
						<span class="glyphicon glyphicon-picture" aria-hidden="true"></span> GALERIA
					</button>

				</div>
			</div>

			<article class="row galeria">
				@if( count($data) != 0 )

		            @foreach( $data as $item )
		            <div class="col-sm-6 col-md-3 col-xs-12"> 
		                <div class="thumbnail text-center" ref="{{ $item['id'] }}"> 

		                    <div class="btn-success btn-xs text-center tag" 
		                        style="position:absolute;top:12px;left:50%;margin-left:-60px;padding:0 26px;display:none;">
		                        <small>SELECIONADA</small>
		                    </div>

		                    <img src="{{ $item['foto'] }}" alt="">
		                    <div class="caption"> 
		                        <h3>{{ $item['name'] }}</h3> 

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
		                            <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span>
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
	    				<button class="btn btn-default redirect" redirect="{{ url('/') }}/homologacao" role="button">
	    					<span class="glyphicon glyphicon-picture" aria-hidden="true"></span> GALERIA
	    				</button>
	    				<button class="btn btn-primary redirect" redirect="{{ url('/') }}/photos-validate" role="button">
	    					PRÓXIMO <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    				</button>
	    			</div>
		        </div>

		        <br><br><br>

		        <div class="col-xs-12 text-center clearfix">
		        	<h4 style="color:#337ab7;">
		        		<span class="total-fotov">0</span> FOTOS SELECIONADAS
		        	</h4>
		        </div>

			</div>
			
			<br/><br/>

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