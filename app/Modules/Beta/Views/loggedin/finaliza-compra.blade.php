@extends('Beta::master')

@section('title', 'Lista de Alunos')

@section('css')
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css">
@endsection

   
@section('content')

 
	<section id="breadcrumb">
		<div class="container">
			<div class="col-xs-12 text-center">
				<i class="fa fa-money fa-2x"></i>
				<h1>FINALIZAR PAGAMENTO</h1>
				<small><b>Home</b> / Finalizar pagamento</small>
			</div>
		</div>
	</section>

	@include('Beta::templates.steps')

	<?php /*
	<section id="breadcrumb-compra" class="hidden-xs">

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
	*/ ?>
	
	<section id="checkout">
		
		<div class="container">
			
			<div class="row content">
	
				<div class="col-md-6 col-sm-6 col-xs-12 descricao">
					
					<h2>Informações</h2>

					<br>

					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#client" aria-controls="home" role="tab" data-toggle="tab">
								<i class="fa fa-user"></i> Cliente
							</a>
						</li>
						<li role="presentation">
							<a href="#address" aria-controls="profile" role="tab" data-toggle="tab">
								<i class="fa fa-map-marker"></i> Endereço
							</a>
						</li>
						<li role="presentation">
							<a href="#descricao" aria-controls="profile" role="tab" data-toggle="tab">
								<i class="fa fa-list"></i> Pedido
							</a>
						</li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="client">
							<br>
							<div class="col-xs-12">
								<form class="formclient">
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<label for="cep">Nome: <small>*</small></label>
											<input type="text" class="form-control" name="nome" disabled value="{{ $client->name }}">
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<label for="cep">Sobrenome: <small>*</small></label>
											<input type="text" disabled class="form-control" name="sobrenome" value="{{ $client->last_name }}">
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-xs-12">
											<label for="cep">Email: <small>*</small></label>
											<input type="text" disabled class="form-control" name="email" value="{{ $client->email }}">
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<label for="cep">Data de Nascimento: <small>*</small></label>
											<input autocomplete="off" type="text" class="form-control" name="data_de_nascimento" value="{{ $client->data_nascimento }}">
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<label for="cep">CPF: <small>*</small></label>
											<input autocomplete="off" type="text" class="form-control" name="cpf" value="{{ $client->cpf }}">
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-12">
											<label for="">Celular: <small>*</small></label>
											<input autocomplete="off" type="text" class="form-control" name="celular" value="{{ $client->celular }}">
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<label for="">Telefone: </label>
											<input type="text" class="form-control" name="telefone" value="{{ $client->telefone }}">
										</div>
									</div>

									<div class="checkbox">
										<label>
											<input type="checkbox" name="salvar_dados" value="1"> Salvar Dados
										</label>
									</div>

								</form>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="address">
							<br>
							
							<div class="col-xs-12">
								<form class="formaddress" autocomplete="off">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label for="cep">CEP: <small>*</small></label>
										<input type="text" class="form-control" name="cep" value="{{ $address->cep }}">
									</div>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<label for="cep">Endereço: <small>*</small></label>
										<input type="text" disabled class="form-control" name="logradouro" value="{{ $address->logradouro }}">
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label for="">Número: <small>*</small></label>
										<input type="text" class="form-control" name="numero" value="{{ $address->numero }}">
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label for="">Complemento: </label>
										<input type="text" class="form-control" name="complemento" value="{{ $address->complemento }}">
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label for="">Bairro: <small>*</small></label>
										<input type="text" disabled class="form-control" name="bairro" value="{{ $address->bairro }}">
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label for="">Cidade: <small>*</small></label>
										<input type="text" disabled class="form-control" name="localidade" value="{{ $address->cidade }}">
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label for="">Estado: <small>*</small></label>
										<input type="text" disabled class="form-control" name="uf" value="{{ $address->estado }}">
									</div>
								</div>
								<br>
								<div class="alert alert-info">
									<i class="fa fa-exclamation"></i> Campo <b>CEP</b> e <b>Número</b> precisa esta preenchido para concluir a compra.
								</div>
							</form>
							</div>
							
						</div>
						<div role="tabpanel" class="tab-pane" id="descricao">
							<br>
							<div class="col-xs-12">
								<table class="table"> 
									<thead> 
										<tr> 
											<th>Descrição</th> 
											<th class="text-center">Quantidade</th> 
											<th class="text-center">Valor Unitário</th> 
											<th class="text-center">Subtotal</th> 
										</tr> 
									</thead>
									<tbody> 
										@foreach( $info as $item )
										<tr> 
											<td>{{ $item['descricao'] }}</td> 
											<td align="center">{{ $item['quantidade'] }}</td> 
											<td align="center">R$ <span>{{ $item['valor_da_unidade'] }}</span></td> 
											<td align="right">R$ <span>{{ $item['subtotal'] }}</span></td> 
										</tr> 
										@endforeach
									</tbody> 
									<tfoot>
										<tr>
											<th>Desconto: </th>
											<td colspan="3" align="right">R$ <span>0</span></td>
										</tr>
										<tr>
											<th>Total: </th>
											<td colspan="3" align="right">R$ <span>0</span></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
	
				</div>
				
				<div class="col-md-6 col-sm-6 col-xs-12 aguardando" style="padding:198px 0;display:none;">
					<div class="text-center">
						<i class="fa fa-spinner fa-2x"></i>
						<h1>Aguarde!</h1>
						<strong>Seu pagamento esta sendo processado.</strong>
					</div>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 pag-sucesso" style="padding:100px 0;display:none;">
					<div class="text-center info">
						<i class="fa fa-check-square-o fa-5x"></i>
						<h1><span></span> Obrigado pela compra!</h1>
						<h2>N. <span>21654651321</span></h2>
						<h3>Recebemos seu pedido!</h3>
						<p>Uma mensagem com detalhe dessa transação foi enviado para seu email</p>
						<p>Confira abaixo os detalhes da sua compra</p>
						<ul style="list-style:none;">
							<li><strong>Status</strong>: <span>Aguardando pagamento</span></li>
							<li><strong>Valor</strong>: <span></span></li>
							<li><strong>Codigo do Pagseguro</strong>: <span></span></li>
							<li><strong>Meio de Pagamento</strong>: <span>Cartão de Credito</span></li>
						</ul>
					</div>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-12 payments">
					
					<h2>Pagamento</h2>
					<br>

					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#credito" aria-controls="home" role="tab" data-toggle="tab">
								<i class="fa fa-credit-card"></i> Crédito
							</a>
						</li>
						<li role="presentation">
							<a href="#debito" aria-controls="profile" role="tab" data-toggle="tab">
								<i class="fa fa-money"></i> Débito
							</a>
						</li>
					</ul>
	
					<div class="tab-content">	
						
						<input type="hidden" name="pagseguro_session" value="{{ PagSeguro::startSession() }}">
						<input type="hidden" name="interest_free" value="{{ $event->interest_free }}">

						<div role="tabpanel" class="tab-pane active" id="credito">
							<br>
							<div class="col-xs-12">
								<form action="" autocomplete="off">
									<div class="row">
										<div class="col-md-6 col-xs-12">
											<label>Número do Cartão</label>
											<input type="text" class="form-control" name="cardBin" maxlength="16">
										</div>

										<div class="col-xs-6 validate_card">
											
											<div class="col-xs-12">
												<label for="">Validade do Cartão</label>	
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="expirationMonth" id="value_month" class="form-control">
													<option value="">Mês</option>
													@for( $m = 1; $m<=12; $m++ )
													<option value="{{ $m }}">{{ $m }}</option>
													@endfor
												</select>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="expirationYear" id="value_year" class="form-control">
													<option value="">Ano</option>
													@for( $y = 2018; $y<=2033; $y++ )
													<option value="{{ $y }}">{{ $y }}</option>
													@endfor
												</select>
											</div>

										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-6 col-xs-12">
											<label for="">Nome impresso no cartão</label>
											<input type="text" class="form-control" name="name_card">
										</div>
										<div class="col-md-6 col-xs-12">
											<label>
												Código de segurança (CVV) 
												<a class="info" href="#" data-toggle="modal" data-target="#cvv" >
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												</a>
											</label>
											<input type="text" class="form-control" name="cvv">
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-xs-12">
											<label for="">Parcelamento em até <span>5x</span> sem juros</label>
											<select name="interest_free" id="parcelas" class="form-control">
												<option amount="0.00" value="0">Número de parcelas</option>
											</select>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="debito">
							Debito
						</div>
					</div>

				</div>

				<div class="col-xs-12 text-right">
					<div class="button">
						<button class="btn btn-primary" name="btn-checkout">PAGAMENTO</button>
					</div>
				</div>

			</div>

			<br><br>

		</div>

	</section>

	<?php /*
	<section id="finaliza-compra">

		<div class="container">
			<div class="row">
			<div class="col-sm-6">
				<div class="cart-container">
					<h2>Dados de Pagamento</h2>
				
					<div class="box-cliente">
					
					<form id="finalizaPagamento" action="{{ url('')}}/teste" method="post">
						{{ csrf_field() }}

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
									<input id="" name="telefone" class="form-control" type="text" value="{{ $cart->cliente->telefone }}" />
								</div>
								<div class="col-md-4">
									<label>Celular</label>
									<input id="clienteFone" name="celular" class="form-control" type="text" value="{{ $cart->cliente->celular }}" />
								</div>
								<div class="col-md-4">
									<label>CPF</label>
									{{-- <input id="clienteCPF" name="cpf" class="form-control" type="number" value="{{ str_replace(array("."," ","-"), array("","",""), $cart->cliente->cpf) }}" /> --}}
									<input id="clienteCPF" name="cpf" class="form-control" type="text" value="{{ str_replace(array("."," ","-"), "", $cart->cliente->cpf) }}" />
									<span class="info">* somente números</span>
								</div>
							</div>
						</div>

						<div class="hidden-xs">
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
				
			</div>
			<div class="col-sm-6">
				<div class="cart-container">
					<h2>Descrição do pedido</h2>

					<div class="body">						
						<div class="table-responsive">
						
  							<table class="table">
							  	<thead>
									<tr>
										<th>
											Descrição Item
										</th>
										<th class="text-center">Quantidade</th>
										<th>Valor Uni.</th>
										<th>Valor Total</th>
									</tr>
								</thead>
								<tbody>
									{{-- lista fotos em carrinho --}}
									<tr>
										<td>
											Fotos do evento: {{ $utils->titulos[0]->event_name }}
										</td>
										<td class="text-center">
											{{ count($cart->imagens) }}
										</td>
										<td>
											R$ {{ number_format(str_replace(',','.', $cart->precoUnidadeImagem), 2, ",",".") }}
										</td>
										<td>
											R$ {{ number_format( (str_replace(',','.', $cart->precoUnidadeImagem) * count($cart->imagens)), 2, ",",".") }}
										</td>
									</tr>

									{{-- Lista politicas em carrinho  --}}
									@foreach ($cart->politicas as $politica)
										<tr>
											<td>
												{{ $politica['titulo'] }}
											</td>
											<td class="text-center">
												1
											</td>
											<td>
												R$ {{  number_format($politica['preco'], 2, ',', '.') }}
											</td>
											<td>
												R$ {{ number_format($politica['preco'], 2, ',', '.') }}
											</td>
										</tr>
									@endforeach
									<tr>
										<td>
											<em>Total de Descontos:</em>
										</td>
										<td class="text-center">
											&nbsp;
										</td>
										<td class="col-sm-2">
											&nbsp;
										</td>
										<td>
											<em>R$ {{ number_format($cart->valDesconto, 2,",",".") }}</em>
										</td>
									</tr>

									<tr>
										<td>
											<b>Valor total dos itens:</b>
										</td>
										<td>
											&nbsp;
										</td>
										<td>
											&nbsp;
										</td>
										<td>
											<b>R$ {{ number_format(($cart->precoTotal + $cart->frete['valor']), 2,",",".") }}</b>
										</td>
									</td>
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
						
					</div>
				</div>
				
			
				<div class="cart-container payment-methods">
					<h2>Metodos de Pagamento</h2>
					
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
									<label>Parcelamento {{ ($utils->parcelas_sem_juros > 1)? 'em até '. $utils->parcelas_sem_juros . 'x sem juros' : ''  }}</label>
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
		
				<div class="fnaliza-compra">
					<br>
					<div class="clearfix"></div>
					<input type="submit" id="btnCheckout" class="btn btn-blue pull-right next-button" value="Finalizar Compra" />
				</div>

			</form>
			</div>
		</div>
		</div>
	</section>
	*/ ?>
	
	<?php /*
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
			</div>
		</div>
	</div>
	*/ ?>

@endsection

@section('scripts')

	<!-- <script type="text/javascript" src="{{ url('/pagseguro/javascript') }}"></script> -->
	
	<?php /*
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
						text: "Insira um Celular válido, com DDD!",
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
								
								$(".load").css("display", "none");
								
								if(response.error){

									var client_id = {{ Auth::guard("cliente")->user()->id }};

									var dados = { 
											client_id : client_id , 
											code : response.error.code , 
											message : response.error.message 
										};									
									
									$.ajax({
										headers: {
											'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										},
										url: "{{ url('pagseguro-error') }}",
										data: dados,
										dataType: 'json',
										type: 'POST',
										success: function(response){
											console.log( response );
										}
									});


									swal({
										title: "Erro inesperado",
										text: 'Houve uma queda no sistema, por favor contate o administrador do site.',
										type: "error"
									});

									console.log( response );

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
							}, 
							error: function(xhr, status, error){
								var erro = JSON.parse(xhr.responseText);								
								var mensagem = '';
								$.each(erro, function( index, value ) {
									mensagem += value +'\n';
								});

								swal({
									title: "Erro: Campos vazios",
									text: mensagem,
									type: "error"
								});

								$(".load").css("display", "none");
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
								maxInstallmentNoInterest: {{ $utils->parcelas_sem_juros }},
								success: function(response) {
									//opções de parcelamento disponível

									$('#brandCard').empty().prepend(brand);

									var parcelas_sem_juros = {{ $utils->parcelas_sem_juros }};

									var html = '<option value="">Parcelas</option>';
									var pacela = '';
									
									response.installments[brand].forEach(function(val, index){
										
										if( index < (parcelas_sem_juros) ){
											parcela = '<em>Sem Juros</em>';
										}else{
											parcela = '';
										}
										
										
										html += '<option amount="'+val.installmentAmount+'"  value="'+ val.quantity +'"> '+ val.quantity + 'x  de  R$ ' + val.installmentAmount.toFixed(2).toString().replace('.',',') + ' ' + parcela + ' </option>';
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

	</script>
	*/ ?>

@endsection

