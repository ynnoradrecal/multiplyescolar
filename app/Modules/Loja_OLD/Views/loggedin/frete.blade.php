@extends('Loja::master')

@section('title', 'Lista de Alunos')

@section('css')
	
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css">
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

	</style>

@endsection

   
@section('content')

	<section id="breadcrumb">
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines">
		<div class="container">

			<div class="col-md-5 noppading">

				<h1>Opções</h1>

			</div>

			<div class="col-md-2 text-center">
				<i class="fa fa-th" aria-hidden="true"></i>
			</div>

			<div class="col-md-5 text-right noppading">

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
			<div class="row">
			<ul>
				<div class="col-md-6 col-sm-6 col-xs-10 col-xs-offset-1 col-md-offset-0 ">
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
						Repositórios 
					</li>
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Galeria 
					</li>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-10 col-xs-offset-1 col-md-offset-0 ">
				<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Opções 
					</li>
					<li class="active"><span>5</span> Entrega </li>
					<li><span>6</span> Pagamento </li>
				</div>
			</ul>
			</div>
		</div>

	</section>

	<section id="finaliza-compra">

		<div class="container">

			{{-- <a href="#" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
				Olá, {{ $cart->cliente->name }}
			</a> --}}
			<div class="row">
			<div class="col-sm-4">
			{{-- {{ dd( $cart ) }} --}}
				
				<?php $i = 0; ?>
				
				@if( count($cart->cliente->enderecos) > 0 )
					<div class="row">
						
						@for($i = 0; $i < count($cart->cliente->enderecos); $i++ )
							<div class="col-md-12">
								
								<div class="box-endereco list-endereco">
									
									<div class="header {{ $cart->cliente->enderecos[$i]->entrega === 1 ? "active" : "" }}">
										
										<ul class="ceps">
											<li>
												<input id="radioEndereco{{ $i }}" class="cep" data-enderecoId="{{ $cart->cliente->enderecos[$i]->id }}" type="radio" name="endereco" value="{{ $cart->cliente->enderecos[$i]->cep }}" {{ $cart->cliente->enderecos[$i]->entrega === 1 ? "checked" : "" }} />
												
											</li>
											<li>
												<label for="radioEndereco{{ $i }}">Endereço de Entrega</label>
											</li>
										</ul>

									</div>
									<div class="body">
										{{ $cart->cliente->enderecos[$i]->logradouro }}, 
										{{ $cart->cliente->enderecos[$i]->numero }} - 
										{{ $cart->cliente->enderecos[$i]->bairro }}<br>
										{{ $cart->cliente->enderecos[$i]->cidade }} -
										{{ $cart->cliente->enderecos[$i]->estado }} - 
										CEP: {{ $cart->cliente->enderecos[$i]->cep }}
									</div>
								</div>
							</div>
						@endfor
						
					</div>
					
					{{-- {{ dd($metodos) }} --}}
					@foreach ( $metodos as $metodo )
					@if( $metodo->slug == 'correios' )
						<div class="row">
							<div class="col-md-12">
								
							<div class="box-endereco">
							<div class="header">
								<h3>Frete: {{ $metodo->nome }}</h3>
							</div>
							<div class="body">
						
							
								<form id="{{ $metodo->slug }}Form" action="{{ url('/') }}/add-to-cart/frete" method="post">
									<input type="hidden" name="cep_origem" value="{{ $metodo->config->cep_origem }}" />
									

									@if( $metodo->config->pac == 1)
										<input id="pac" type="radio" name="servico" value="41106" /> 
										<label for="pac">PAC</label>&nbsp;&nbsp;&nbsp;&nbsp;
									@endif

									@if( $metodo->config->sedex == 1)
										<input id="sedex" type="radio" name="servico"  value="40010" /> 
										<label for="sedex">SEDEX</label>&nbsp;&nbsp;&nbsp;&nbsp;
									@endif

									@if( $metodo->config->sedex_10 == 1)
										<input id="sedex_10" type="radio" name="servico" value="40215" /> 
										<label for="sedex_10">SEDEX 10</label>
									@endif

									<br><br>

									<p id="retornoFreteMessage"></p>
									<p id="retornoFreteValor"></p>
									<p id="retornoFretePrazo"></p>

									<input id="valorTotal" type="hidden" name="valorTotal" value="{{ $cart->precoTotal }}" />
									<input id="diasAdicionais" type="hidden" name="diasAdicionais" value="{{ $metodo->config->dias_adicionais }}" />
									<input id="valorAdicional" type="hidden" name="valorAdicional" value="{{ $metodo->config->taxa_adicional }}" />
									<a id="getVal" href='#' class="btn btn-md btn-blue next-button">Calcular Frete <i  class="frete-spin fa fa-refresh fa-spin fa-1x" style="display: none;"></i></a>

								</form>
							
							</div>
							</div>
							</div>
						</div>
						@elseif( $metodo->slug == 'gratis' && $cart->precoTotal > 4000.00 )

						@endif
						<?php $i++; ?>
					@endforeach

				@else
					<div class="row">
						<div class="col-md-12">
							<div class="box-endereco">
								<div class="header">
									<h3>Cadastro de endereco</h3>
								</div>
								<div class="body">
									<form action="{{ url('/add-to-cart/frete/endereco') }}" method="POST">
										
										{{ csrf_field() }}

										<input type="hidden" name="user_id" value="{{ Auth::guard('cliente')->user()->id }}" />										

										<div class="col-md-12">
											<div class="form-group {{ $errors->has('cep') ? 'has-error' : ''}}">
												<input class="form-control" type="text" name="cep" value="{{ old('cep')}}" placeholder="CEP" />
												{!! $errors->first('cep', '<p class="help-block">:message</p>') !!}
											</div>
										</div>
										
										<div class="col-md-12">
											<div class="form-group">
												<input class="form-control" type="text" name="logradouro" value="{{ old('logradouro')}}" placeholder="Endereço" />
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<input class="form-control" type="text" name="numero" value="{{ old('numero')}}" placeholder="Número" />
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<input class="form-control" type="text" name="complemento" value="{{ old('complemento')}}" placeholder="Complemento" />
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<input class="form-control" type="text" name="bairro" value="{{ old('bairro')}}" placeholder="Bairro" />
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<input class="form-control" type="text" name="cidade" value="{{ old('cidade')}}" placeholder="Cidade" />
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<input class="form-control" type="text" name="estado" value="{{ old('estado')}}" placeholder="Estado" />
											</div>
										</div>

										<div class="col-md-12">
											<input class="btn btn-blue btn-lg" type="submit" value="Salvar" />
										</div>
									</form>
									<div class="clearfix"></div>
								</div>
								
							</div>
							
						</div>
						
					</div>
				@endif
				
			</div>
			<div class="col-sm-8">
				<div class="cart-container">
					<h2>Descrição do pedido</h2>
					<div class="header">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-5">
									Descrição Item
								</div>
								<div class="col-sm-2">Quantidade</div>
								<div class="col-sm-2">Valor Uni.</div>
								<div class="col-sm-3">Valor Total</div>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="col-sm-12">
							{{-- lista fotos em carrinho --}}
							<div class="row">
								<div class="col-sm-5">
									Fotos do evento: {{ $utils[0]->event_name }}
								</div>
								<div class="col-sm-2 text-center">
									{{ count($cart->imagens) }}
								</div>
								<div class="col-sm-2">
									R$ {{ number_format(str_replace(',','.',$cart->precoUnidadeImagem), 2, ",",".") }}
								</div>
								<div class="col-sm-3">
									R$ {{ number_format( (str_replace(',','.',$cart->precoUnidadeImagem) * count($cart->imagens)), 2, ",",".") }}
								</div>
							</div>

							{{-- Lista politicas em carrinho  --}}
							@foreach ($cart->politicas as $politica)
								<div class="row">
									<div class="col-sm-5">
										{{ $politica['titulo'] }}
									</div>
									<div class="col-sm-2 text-center">
										1
									</div>
									<div class="col-sm-2">
										R$ {{  number_format($politica['preco'], 2, ',', '.') }}
									</div>
									<div class="col-sm-3">
										R$ {{ number_format($politica['preco'], 2, ',', '.') }}
									</div>
								</div>
							@endforeach
							<div class="row">
								<div class="col-sm-5">
									<b>Valor total dos itens:</b>
								</div>
								<div class="col-sm-2 text-center">
									&nbsp;
								</div>
								<div class="col-sm-2">
									&nbsp;
								</div>
								<div class="col-sm-3">
									<b>R$ {{ number_format($cart->precoTotal, 2,",",".") }}</b>
								</div>
							</div>

						</div>
						<div class="clearfix"></div>
						
					</div>
				</div>
				<div class="fnaliza-compra">
				<form id="formFreteData" action="{{ url('/') }}/add-to-cart/frete" method="POST">

					 {{ csrf_field() }}

					 <input type="hidden" name="prazo" value="" />
					 <input type="hidden" name="valor" value="" />
					 <input type="hidden" name="cep" value="" />
					 <input type="hidden" name="endereco_id" value="" />
					
					<br><br>
					{{-- <p class="pull-right">Valor total da compra com frete é <span id="valor-total"></span></p><br> --}}
					<div class="clearfix"></div>
					<input type="submit" class="btn btn-blue pull-right next-button" value="Finalizar Compra" />
				</div>
			</div>

			</div>
		</div>

  	</section>

@endsection

@section('scripts')

<script type="text/javascript">
	
	$(document).ready(function(){

		//Quando o campo cep perde o foco.
		$("input[name='cep']").blur(function() {

			//Nova variável "cep" somente com dígitos.
			var cep = $(this).val().replace(/\D/g, '');

			//Verifica se campo cep possui valor informado.
			if (cep != "") {

				//Expressão regular para validar o CEP.
				var validacep = /^[0-9]{8}$/;

				//Valida o formato do CEP.
				if(validacep.test(cep)) {

					//Consulta o webservice viacep.com.br/
					$.getJSON("//viacep.com.br/ws/"+ cep.replace(/[^0-9]/g,'') +"/json/?callback=?", function(dados) {

						if (!("erro" in dados)) {
							//Atualiza os campos com os valores da consulta.
							$("input[name='logradouro']").val(dados.logradouro);
							$("input[name='bairro']").val(dados.bairro);
							$("input[name='cidade']").val(dados.localidade);
							$("input[name='estado']").val(dados.uf);
						} //end if.
						else {
							//CEP pesquisado não foi encontrado.
							alert("CEP não encontrado.");
						}
					});
				} //end if.
				else {
					//cep é inválido.
					alert("Formato de CEP inválido.");
				}
			} //end if.
			else {
				//cep sem valor, limpa formulário.
			}
		});


		$('#formFreteData').submit(function(){
			
			if($(this).find('input[name="prazo"]').val().length == 0){
				
				swal({
					title: "Erro no frete",
					text: "Escolha um metodo de frete.",
					timer: 2900,
					showConfirmButton: false,
					type: 'error'
				});

				return false;
			}
			
			return true;
		});

		$('.box-endereco input[type="radio"]').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		});

		$('.box-endereco input[type="radio"]').on('ifChecked', function(){
			$('.list-endereco').css('border','solid 1px #eee');
		})

		var data = $('input[type="radio"].cep').data();
		var endereco_id = data.enderecoid;

		// insere cep do endereço ao formulário de envio de dados do frete
		$('#formFreteData input[name="cep"]').val( $('input[type="radio"].cep').val() );

		// insere endereco_id ao formulário de envio de dados do frete
		$('#formFreteData input[name="endereco_id"]').val(endereco_id);

		$('input[type="radio"].cep').on('ifChecked', function(){
			// get data com o novo id
			data = $(this).data()
			endereco_id = data.enderecoid
			
			// atualiza dados do formulário que envia dados do frete
			$('#formFreteData input[name="endereco_id"]').val(endereco_id);
			$('#formFreteData input[name="cep"]').val( $(this).val() );
		});

		
		$('#getVal').click(function(e){
			e.preventDefault();			
			
			$(".frete-spin").css("display","inline-block");

			//alert('teste');

			// recebe cep destino
			var cep_destino = $(".ceps").find('input[type="radio"]:checked').val();

			// cep de origem
			var cep_origem = $('input[name="cep_origem"]').val();

			if( cep_origem.length < 8){
				
				swal({
					title: "Erro no Cep de Origem",
					text: "Por favor, escolha o endereço de entrega.",
					timer: 3000,
					showConfirmButton: false,
					type: 'error'
				});

				$(".frete-spin").css("display","none");
			}

			// get cod serviço
			var $form = $('#correiosForm');
			var cod_servico = $form.find('input[type="radio"]:checked').val();

			var valor_pedido = $('#valorTotal').val();

			var dias_adicionais = $('#diasAdicionais').val();

			var valor_adicional = $('#valorAdicional').val();


			if(!cod_servico){
				
				swal({
					title: "Erro no frete",
					text: "Por favor, escolha um serviço em metodos de pagamento.",
					timer: 4000,
					showConfirmButton: false,
					type: 'error'
				});

				$(".frete-spin").css("display","none");
				
				return false;
			}else{
				 if (!$("input[name='endereco']").is(':checked')) {
					/*alert('Escolha o endereço de entrega.');*/
					swal({
						title: "Errro no endereço",
						text: "Por favor, escolha o endereço de entrega.",
						timer: 3000,
						showConfirmButton: false,
						type: 'error'
					});

					$('.list-endereco').css('border','solid 1px #B30000');
					return false;
				}
			}

			if(calculaFrete(cod_servico, cep_origem, cep_destino, valor_pedido, dias_adicionais, valor_adicional)){
				$(".frete-spin").css({"display":"none"});
			}
			
		})
			
	});

	function calculaFrete(cod_servico, cep_origem, cep_destino, valor_pedido = 0.00, dias_adicionais, valor_adicional){

		var args = {
			nCdServico : cod_servico,
			sCepOrigem : cep_origem,
			sCepDestino : cep_destino,
			nVlPeso : '1',
			nCdFormato : 1,
			nVlComprimento : 20.5,
			nVlAltura : 20.5,
			nVlLargura : 20.5,
			nVlDiametro : 0.00,
			nVlValorDeclarad: valor_pedido

		}

		$.ajax({
			method: 'GET',
			url: 'http://correios-server.herokuapp.com/frete/prazo?',
			data: args,
			success: function(data){
				//console.log(data.response[0]['Codigo']);

				if(data.response[0]['Erro']){
					
					if( data.response[0]['MsgErro'].length > 0 ){
						$('#retornoFreteMessage').css('display', 'block');
						$('#retornoFreteMessage').text(data.response[0]['MsgErro']);
					}else{
						$('#retornoFreteMessage').css('display', 'none');
					}

					
					var prazo = parseInt(data.response[0]['PrazoEntrega']) + parseInt(dias_adicionais);
					var valorTotal = ((parseFloat( data.response[0]['Valor'].replace(',','.') ) + parseFloat(valor_adicional)).toFixed(2)).toString();

					$('#retornoFreteMessage').addClass('alert alert-danger');
					$('#retornoFreteValor').html( '<b>Valor de entrega:</b> R$ '+ (valorTotal.replace('.',',')) );
					$('#retornoFretePrazo').html( '<b>Prazo de entrega:</b> '+  prazo  + ' dias' );
					
				}else{
					$('#retornoFreteValor').html( '<b>Valor de entrega:</b> R$ '+ data.response[0]['Valor'].replace('.',',') );
					$('#retornoFretePrazo').html( '<b>Prazo de entrega:</b> '+ data.response[0]['PrazoEntrega'] + ' dias');
					$('#retornoFreteMessage').css('display', 'none');
					$('#retornoFreteMessage').text("").removeClass('alert alert-danger');
				}

				$('#formFreteData input[name="prazo"]').val(prazo);
				$('#formFreteData input[name="valor"]').val(valorTotal);
				$('#valor-total').html('R$ '+ ( valorTotal + $('#valorTotal').val()) );
			}

		});

		return true;
	}
</script>
@endsection

