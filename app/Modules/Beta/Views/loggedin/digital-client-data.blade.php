@extends('Beta::master')

@section('title', 'Dados cliente Arquivo Digital')

@section('css')
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css">
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
					<li>Finaliza Compra</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">

	</section>


	<section id="breadcrumb-compra">

		<div class="container">

			<ul>
				<div class="col-md-6 col-sm-6 col-xs-10 col-xs-offset-1 col-md-offset-0">
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
				<div class="col-md-6 col-sm-6 col-xs-10 col-xs-offset-1 col-md-offset-0">
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Opções 
					</li>
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span> 
						Entrega 
					</li>
					{{-- <li class="active"><span>4</span> Opções </li>
					<li><span>5</span> Entrega </li> --}}
					<li class="active"><span>7</span> Pagamento </li>
				</div>
			</ul>

		</div>

	</section>

	<section id="finaliza-compra">

		<div class="container">
			
			<form id="formDigitalPayment" method="post">
			
			{{ csrf_field() }}
			
			<div class="row">
			
			<div class="col-sm-6">
				
				<div class="cart-container">
					<h2>Dados de Pagamento</h2>			
					<input name="name" type="hidden" value="{{ $cart->cliente->id }}" />
					<div class="box-cliente">

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Nome</label>
									<input name="name" class="form-control" type="text" value="{{ $cart->cliente->name }}" />
								</div>
								<div class="col-md-6">
									<label>Sobrenome</label>
									<input name="last_name" class="form-control" type="text" value="{{ $cart->cliente->last_name }}" />
								</div>
							</div>							
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-8">
									<label>Email</label>
									<input name="email" class="form-control" type="email" value="{{ $cart->cliente->email }}" />
								</div>
								<div class="col-md-4">
									<label>Data de nascimento</label>
									<input id="clienteDOB" name="data_nascimento" class="form-control" type="text" value="{{ $cart->cliente->data_nascimento }}" />
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Telefone</label>
									<input id="clienteFone" name="telefone" class="form-control" type="text" value="{{ $cart->cliente->telefone }}" />
								</div>
								<div class="col-md-4">
									<label>Celular</label>
									<input id="clienteCel" name="celular" class="form-control" type="text" value="{{ $cart->cliente->celular }}" />
								</div>
								<div class="col-md-4">
									<label>CPF</label>
									{{-- <input id="clienteCPF" name="cpf" class="form-control" type="number" value="{{ str_replace(array("."," ","-"), array("","",""), $cart->cliente->cpf) }}" /> --}}
									<input id="clienteCPF" name="cpf" class="form-control" type="text" value="{{ str_replace(array("."," ","-"), "", $cart->cliente->cpf) }}" />
									<span class="info">* somente números</span>
								</div>
							</div>
						</div>

						{{--  {{ dd( empty($cart->cliente->enderecos )) }}  --}}
						
						@if( empty( $cart->cliente->enderecos ) )

							<div class="row">
								<div class="col-md-12">
									<h2>Endereço de Cobrança</h2>
								</div>
							</div>
								{{--  @foreach(  $cart->cliente->enderecos as $endereco)  --}}
							
							{{--  @if( $endereco->id == $cart->frete['endereco_id'] )  --}}

							<div class="form-group">	
								<div class="row">
									<div class="col-md-5">
										<label>CEP</label>
										<input name="cep" id="clienteCEP" class="form-control" type="text" value="" placeholder="CEP" />
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<label>Logradouro</label>
										<input name="logradouro" id="clienteLogradouro" class="form-control" type="text" value="" placeholder="Digite o nome da Rua" />
									</div>
									<div class="col-md-4">
										<label>Número</label>
										<input name="numero" id="clienteNum" class="form-control" type="text" value="" placeholder="Número" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Complemento</label>
										<input name="complemento" class="form-control" type="text" value="" placeholder="Complemento" />
									</div>
									
									<div class="col-md-6">
										<label>Bairro</label>
										<input name="bairro" id="clienteBairro" class="form-control" type="text" value="" placeholder="Bairro" />
									</div>
								</div>
							</div>

							<div class="form-group">									
								<div class="row">										
									<div class="col-md-6">
										<label>Cidade</label>
										<input name="cidade" id="clienteCidade" class="form-control" type="text" value="" placeholder="Cidade" />
									</div>

									<div class="col-md-6">
										<label>Estado</label>
										<input name="estado" id="clienteEstado" class="form-control" type="text" value="" placeholder="Estado" />
									</div>

								</div>
							</div>

							{{--  @endif  --}}

						{{--  @endforeach  --}}
						@else

							<div class="row">
								<div class="col-md-12">
									<h2>Escolha o Endereço de Cobrança</h2>
								</div>
							</div>

							<input id="idEndereco" name="id_endereco" type="hidden" value="0" />

							<div class="row">
							@for($i = 0; $i < count($cart->cliente->enderecos); $i++ )
								<div class="col-md-6">
									
									<div class="box-endereco list-endereco">
										
										<div class="header {{ $cart->cliente->enderecos[$i]->entrega === 1 ? "active" : "" }}">
											
											<ul class="ceps">
												<li>
													<input id="radioEndereco{{ $i }}" onclick="addIdEndereco({{ $cart->cliente->enderecos[$i]->id }});" class="cep" data-enderecoId="{{ $cart->cliente->enderecos[$i]->id }}" type="radio" name="endereco_id" value="{{ $cart->cliente->enderecos[$i]->id }}" {{ $cart->cliente->enderecos[$i]->entrega === 1 ? "checked" : "" }} />
												</li>
												<li>
													<label for="radioEndereco{{ $i }}">Endereço de Cobrança</label>
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

						@endif
						
						
					</div>	
				</div>
				
			</div>
			<div class="col-sm-6">
				<div class="cart-container">
					<h2>Descrição do pedido</h2>
					<div class="header">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-4">
									Descrição Item
								</div>
								<div class="col-sm-2">Qtd</div>
								<div class="col-sm-3">Valor Uni.</div>
								<div class="col-sm-3">Valor Total</div>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="col-sm-12">
							{{-- lista fotos em carrinho --}}
							<div class="row">
								<div class="col-sm-4">
									Fotos do evento: {{ $utils->titulos[0]->event_name }}
								</div>
								<div class="col-sm-2">
									{{ count($cart->imagens) }}
								</div>
								<div class="col-sm-3">
									R$ {{ number_format(str_replace(',','.', $cart->precoUnidadeImagem), 2, ",",".") }}
								</div>
								<div class="col-sm-3">
									R$ {{ number_format( (str_replace(',','.', $cart->precoUnidadeImagem) * count($cart->imagens)), 2, ",",".") }}
								</div>
							</div>

							{{-- Lista politicas em carrinho  --}}
							@foreach ($cart->politicas as $politica)
								<div class="row">
									<div class="col-sm-4">
										{{ $politica['titulo'] }}
									</div>
									<div class="col-sm-2 ">
										1
									</div>
									<div class="col-sm-3">
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
									<b>R$ {{ number_format(($cart->precoTotal + $cart->frete['valor']), 2,",",".") }}</b>
								</div>
							</div>

						</div>
						<div class="clearfix"></div>
						
					</div>
					
				</div>
				<div class="form-group">
				<br>
					<input type="submit" class="btn btn-blue btn-lg pull-right" value="Continuar para Finalizar Compra" />
				</div>
				<div class="clearfix"></div>
			</div>

		</form>
		</div>

	</section>

	<!-- Modal CVV  -->
	<div id="cvv" class="modal fade"  tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Código CVV</h4>
				</div>
				<div class="modal-body">
					<p>Código de 3 digitos no verso do cartão.</p>
					<img src="{{ asset('images/cvv.png') }}" class="img-responsive" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialo -->
	</div>

@endsection

@section('scripts')

	<script type="text/javascript" src="{{ url('/pagseguro/javascript') }}"></script>

	<script>

		//PagSeguroRecorrente tem um método identico, use o que preferir neste caso, não tem diferença.
		PagSeguroDirectPayment.setSessionId('{{ PagSeguro::startSession() }}');
		
		$(document).ready(function(){

			// $('#formDigitalPayment').submit(function(){
			// 	alert("teste");
			// 	return false;
			// })

			$('.box-endereco input[type="radio"]').iCheck({
				checkboxClass: 'icheckbox_flat-blue',
				radioClass: 'iradio_flat-blue'
			});

			$('.box-endereco input[type="radio"]').on('ifChecked', function(){
				$('#idEndereco').val($(this).val());
			});

			$('#formDigitalPayment').submit(function(){

				if( $('#idEndereco').val() == 0 ){		
					swal({
						title: "Erro com o Endereço",
						text: "Escolha um endereço para continuar!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( !validaCPF($('#clienteCPF').val()) ){
					$('#clienteCPF').focus();			
					swal({
						title: "Erro nos dados do CPF",
						text: "Insira um CPF válido!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteFone').val().length < 10){
					$('#clienteFone').focus();
					swal({
						title: "Erro com o número de telefone",
						text: "Insira um Telefone válido, com DDD!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteDOB').val().length < 10){
					$('#clienteDOB').focus();
					swal({
						title: "Erro com a data de nascimento",
						text: "Por favor digite uma data de nascimento válida!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteCel').val().length < 10){
					$('#clienteCel').focus();
					swal({
						title: "Erro com número de celular",
						text: "Por favor digite um número de celular válido!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteCEP').val().length != 9){
					$('#clienteCEP').focus();
					swal({
						title: "Erro com número de CEP",
						text: "Por favor digite um número de CEP válido!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteLogradouro').val().length < 2){
					$('#clienteLogradouro').focus();
					swal({
						title: "Erro com o Endereço",
						text: "Por favor digite um logradouro válido!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteNum').val().length == 0 ){
					$('#clienteNum').focus();
					swal({
						title: "Erro com o Número",
						text: "Por favor digite um número para o enderço!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteNum').val().length == 0 ){
					$('#clienteNum').focus();
					swal({
						title: "Erro com o Número",
						text: "Por favor digite um número para o enderço!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteBairro').val().length == 0 ){
					$('#clienteBairro').focus();
					swal({
						title: "Erro com o Bairro",
						text: "Por favor digite um bairro válido!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteEstado').val().length == 0 ){					
					$('#clienteEstado').focus();
					swal({
						title: "Erro com o Estado",
						text: "Por favor digite um estado válido!",
						timer: 5000,
						showConfirmButton: true,
						type: 'error'
					});
					return false;
				}

				return true;
			});
			

			$('.payment-methods input[type="checkbox"]').iCheck({
				checkboxClass: 'icheckbox_flat-blue'
			});
			$('.payment-methods input[type="radio"]').iCheck({
				radioClass: 'iradio_flat-blue'
			});
		})

		function addIdEndereco(id)
		{
			$('#idEndereco').val(id);
			return false;
		}


		function validaCPF(cpf)
		{
			var numeros, digitos, soma, i, resultado, digitos_iguais;
			digitos_iguais = 1;
			if (cpf.length < 11)
				return false;
			for (i = 0; i < cpf.length - 1; i++)
				if (cpf.charAt(i) != cpf.charAt(i + 1))
						{
						digitos_iguais = 0;
						break;
						}
			if (!digitos_iguais)
				{
				numeros = cpf.substring(0,9);
				digitos = cpf.substring(9);
				soma = 0;
				for (i = 10; i > 1; i--)
						soma += numeros.charAt(10 - i) * i;
				resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
				if (resultado != digitos.charAt(0))
						return false;
				numeros = cpf.substring(0,10);
				soma = 0;
				for (i = 11; i > 1; i--)
						soma += numeros.charAt(11 - i) * i;
				resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
				if (resultado != digitos.charAt(1))
						return false;
				return true;
				}
			else
				return false;
		}

	</script>

@endsection

