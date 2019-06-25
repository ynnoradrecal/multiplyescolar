@extends('Loja::master')

@section('title', 'Lista de Alunos')

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
					<li class="exhausted">
						<span>
							<i class="fa fa-check" aria-hidden="true"></i>
						</span>
						Formato 
					</li>
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
					<li class="active"><span>6</span> Pagamento </li>
				</div>
			</ul>

		</div>

	</section>

	<section id="finaliza-compra">

		<div class="container">
			<div class="row">
			<div class="col-sm-6">
				<div class="cart-container">
					<h2>Dados de Pagamento</h2>
				
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
									<input name="data_nascimento" class="form-control" type="text" value="{{ $cart->cliente->data_nascimento }}" />
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
									<input name="celular" class="form-control" type="text" value="{{ $cart->cliente->celular }}" />
								</div>
								<div class="col-md-4">
									<label>CPF</label>
									{{-- <input id="clienteCPF" name="cpf" class="form-control" type="number" value="{{ str_replace(array("."," ","-"), array("","",""), $cart->cliente->cpf) }}" /> --}}
									<input id="clienteCPF" name="cpf" class="form-control" type="text" value="{{ str_replace(array("."," ","-"), "", $cart->cliente->cpf) }}" />
									<span class="info">* somente números</span>
								</div>
							</div>
						</div>

						
						<div class="row">
							<div class="col-md-12">
								<h2>Endereço de entrega</h2>
							</div>
						</div>

						

						
						@foreach(  $cart->cliente->enderecos as $endereco)
							
							@if( $endereco->id == $cart->frete['endereco_id'] )

								<div class="form-group">
									<div class="row">
										<div class="col-md-8">
											<label>Logradouro</label>
											<input name="logradouro" class="form-control" type="text" value="{{ $endereco->logradouro }}" disabled/>
										</div>
										<div class="col-md-4">
											<label>Número</label>
											<input name="numero" class="form-control" type="text" value="{{ $endereco->numero }}" disabled/>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-7">
											<label>Complemento</label>
											<input name="complemento" class="form-control" type="text" value="{{ $endereco->complemento }}" disabled/>
										</div>
										<div class="col-md-5">
											<label>CEP</label>
											<input name="cep" class="form-control" type="text" value="{{ $endereco->cep }}" disabled/>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Bairro</label>
											<input name="bairro" class="form-control" type="text" value="{{ $endereco->bairro }}" disabled/>
										</div>
										<div class="col-md-6">
											<label>Cidade</label>
											<input name="cidade" class="form-control" type="text" value="{{ $endereco->cidade }}" disabled/>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Estado</label>
											<input name="estado" class="form-control" type="text" value="{{ $endereco->estado }}" disabled/>
										</div>
									</div>
								</div>

							@endif

						@endforeach
						
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
				
			<form id="finalizaPagamento" action="{{ url('')}}/teste" method="post">
				<div class="cart-container payment-methods">
					<h2>Metodos de Pagamento</h2>
					{{ csrf_field() }}
					<input name="token" type="hidden" value="" />
					<input name="brand" type="hidden" value="" />
					<input type="hidden" name="senderHash" value="" />
					<input type="hidden" name="valor_parcela" value="0.00" />
					<input type="hidden" name="valor_frete" value="{{ $cart->frete['valor'] }}" />

					<input id="valorTotal" name="valorTotal" type="hidden" value="{{ ($cart->precoTotal + $cart->frete['valor'])}}" />

					<div class="header">
					
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-7 ">
									<input id="credit" name="payment_method" type="radio" value="credit" checked />
									<label for="credit">Cartão de crédito</label>
								</div>
								<div class="col-sm-5">
									<img src="{{ asset('images/logo-pagseguro.png')}}" class="img-responsive" />
								</div>
							</div>
						</div>
					</div>

					<div class="">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Número do Cartão</label>
									<input class="form-control" id="card_number" name="card_number" type="text" />
									<span id="brandCard" class="info"></span>
								</div>
								<div class="col-md-5">
									
									<label>Validade do Cartão</label>
									
									<div class="row">
										<div class="col-md-6">
											<select name="value_month" id="value_month" class="form-control">
												<option value="0">Mês</option>
												<option value="1">01</option>
												<option value="2">02</option>
												<option value="3">03</option>
												<option value="4">04</option>
												<option value="5">05</option>
												<option value="6">06</option>
												<option value="7">07</option>
												<option value="8">08</option>
												<option value="9">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											</select>
										</div>
										<div class="col-md-6">

											<select name="value_year" id="value_year" class="form-control">
												<option value="0">Ano</option>
												@for($i = 0; $i <= 15; $i++ )
													<option value="{{ (date("Y") + ($i)) }}">{{ (date("Y") + ($i)) }}</option>
												@endfor
											</select>

										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Nome impresso no cartão</label>
									<input class="form-control" name="card_name" type="text" />
								</div>
								<div class="col-md-5">
									<label>
										Código de segurança (CVV) 
										<a class="info" href="javascript:void(0)" data-toggle="modal" data-target="#cvv">
											<i class="fa fa-question-circle" aria-hidden="true"></i>
										</a>
									</label>
									<input class="form-control" name="cvv_code" type="text" />
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-11">
									<label>Parcelamento </label>
									<select name="parcelas" id="parcelas" class="form-control">
										<option amount="0.00" value="0">Número de parcelas</option>
									</select>
									<span class="info">* Insira o número do cartão para ver as formas de parcelamento</span>
								</div>

							</div>
						</div>

					</div>

					<div class="clearfix"></div>
				</div>
			


			</div>
		
			<div class="fnaliza-compra">
				<br><br>
				<div class="clearfix"></div>
				<input type="submit" id="btnCheckout" class="btn btn-blue pull-right next-button" value="Finalizar Compra" />
			</div>
			</form>
		</div>
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

			$('#btnCheckout').off('click').on('click', function(e){
				e.preventDefault();

				if( !validaCPF($('#clienteCPF').val()) ){					
					swal({
						title: "Erro nos dados do CPF",
						text: "Insira um CPF válido!",
						timer: 5000,
						showConfirmButton: false,
						type: 'error'
					});
					return false;
				}

				if( $('#clienteFone').val().length < 10){
					
					swal({
						title: "Erro nos dados de contatto",
						text: "Insira um Telefone válido, com DDD!",
						timer: 5000,
						showConfirmButton: false,
						type: 'error'
					});
					return false;
				}

				$("input[name='senderHash']").val(PagSeguroDirectPayment.getSenderHash());

				var cardNumber = $("input[name='card_number']").val().replace(/ /g,'');
				var cvv = $("input[name='cvv_code']").val();
				var brand = $("input[name='brand']").val();
				var month = $("#value_month").val();
				var year = $("#value_year").val();

				if( cardNumber.length == 0 ){
					swal({
						title: "Erro no cartão",
						text: "Insira o número do cartão!",
						timer: 4000,
						showConfirmButton: false,
						type: 'error'
					});
					return false;
				}

				if( brand.length == 0 ){
					swal({
						title: "Erro no cartão",
						text: "O número do cartão está incorreto!",
						timer: 3000,
						showConfirmButton: false,
						type: 'error'
					});
					return false;
				}

				if( month == 0 ){
					swal({
						title: "Mês inválido",
						text: "Escolha o mês de vencimento!",
						timer: 3000,
						showConfirmButton: false,
						type: 'error'
					});
					return false;
				}

				if( year == 0 ){
					swal({
						title: "Ano inválido",
						text: "Escolha o ano de vencimento!",
						timer: 3000,
						showConfirmButton: false,
						type: 'error'
					});
					return false;
				}

				if( cvv.length < 3 ){
					swal({
						title: "Erro no código CVV",
						text: "Insira um código CVV válido com no mínimo 3 numeros!",
						timer: 4000,
						showConfirmButton: false,
						type: 'error'
					});
					return false;
				}

				PagSeguroDirectPayment.createCardToken({
					
					cardNumber: cardNumber,
					brand: brand,
					cvv: cvv,
					expirationMonth: month,
					expirationYear: year,
					
					success: function(response){
						// token gerado, esse deve ser usado na chamada da API do Checkout Transparente
						$("input[name='token']").val(response.card.token);
						$(".load").css("display", "block");

						$.ajax({
							url: "{{ url('') }}/realiza-pagamento",
							data: $('#finalizaPagamento').serialize(),
							dataType: 'json',
							type: 'POST',
							success: function(response){
								
								if(response.error){
									alert('Deu erro');
									console.log(response);
									$(".load").css("display", "none");
								}else{

									if(response.code) {
										$(".load").css("display", "none");
										swal({
											title: "Compra realizada com sucesso",
											text: "Nossa equipe já foi informada e estamos separando o seu pedido. Muito Obrigado!",
											type: "success",
											showCancelButton: false,
											confirmButtonText: "Retornar a tela de pedidos",
											closeOnConfirm: false
										},
										function(isConfirm){
											window.location.href = "{{ url('minha-conta/'. Auth::guard("cliente")->user()->id .'/pedidos') }}";
										});
									}
									
									console.log(response)
								}
							}
						})
						
					},
					error: function(response){
						swal({
							title: "Erro nos dados do cartão",
							text: "Por favor, verifique se os dados do cartão estão corretos e tente novamente.",
							timer: 5000,
							showConfirmButton: false,
							type: 'error'
						});
						
					},
					complete: function(response){
						console.log('Concluído');
					}
				});
			})

			$('#parcelas').change(function(){
				var valor_parcela = $(this).find(':selected').attr("amount");
				$('input[name="valor_parcela"]').val( parseFloat(valor_parcela).toFixed(2) );
			})

			$("input[name='card_number']").off('focusout').on('focusout', function(){
				
				var cardNum = $(this).val().replace(/ /g,'');
				var countCardNum = cardNum.length;
				
				if(countCardNum != 16){
					swal({
						title: "Erro nos dados do cartão",
						text: "Por favor, digite numero do cartão corretamente.",
						timer: 5000,
						showConfirmButton: false,
						type: 'error'
					});
				}else{
					
					PagSeguroDirectPayment.getBrand({
						cardBin: $("input[name='card_number']").val().replace(/ /g,''),
						success: function(json){

							var brand = json.brand.name;

							$("input[name='brand']").val(brand);

							PagSeguroDirectPayment.getInstallments({
								amount: $("input#valorTotal").val(),
								brand: brand,
								maxInstallmentNoInterest: 0,
								success: function(response) {
									//opções de parcelamento disponível

									$('#brandCard').empty().prepend(brand);

									var html = '<option value="">Parcelas</option>';
									
									response.installments[brand].forEach(function(val, index){
										html += '<option amount="'+val.installmentAmount+'"  value="'+ val.quantity +'"> '+ val.quantity + 'x de  R$ ' + val.installmentAmount.toFixed(2).toString().replace('.',',') + '</option>';
									})

									$("select#parcelas").html(html);
								},
								error: function(response) {
								//tratamento do erro
								},
								complete: function(response) {
								//tratamento comum para todas chamadas
								}
							})
						},
						error: function(json){
							console.log(json);
						},
						complete: function(json){
						}
					});
				}
			})

			$('.payment-methods input[type="checkbox"]').iCheck({
				checkboxClass: 'icheckbox_flat-blue'
			});
			$('.payment-methods input[type="radio"]').iCheck({
				radioClass: 'iradio_flat-blue'
			});
		})


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

