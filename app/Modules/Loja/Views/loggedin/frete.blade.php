@extends('Loja::master')
@section('title', 'Serviço de Entrega')
@section('css')
	
	<link rel="stylesheet" href="{{ asset("css") }}/lightbox.min.css">
	
	<style type="text/css" media="screen">

		#finaliza-compra .block-left div h3 { color: #289cde; }
		#finaliza-compra .block-left div p { margin-left: 16px; font-weight: 400; color: #444; }
		#finaliza-compra .block-left a { margin-left: 16px; }

		#finaliza-compra .block-right div h3 { color: #289cde; }
		#finaliza-compra .block-right .form-group input { background:#f4f4f4;border-radius:0;margin-top:12px; }

		#finaliza-compra .block-right div > a { padding:13px 32px 10px; }

	</style>

@endsection

   
@section('content')

	<section id="breadcrumb">
		
		<div class="container">

			<div class="col-xs-12 text-center">

				<i class="fa fa-truck fa-2x"></i>
				<h1>ENTREGA</h1>
				<small><b>Home</b> / Entrega</small>

			</div>

		</div>

	</section>

	@include('Loja::templates.steps')

	<section id="finaliza-compra">
		
		<div class="container">
			
			<div class="header row clearfix">
				
				<div class="col-xs-12">
					<div class="jumbotron" style="margin-bottom:5px;">

						<h1>{{ $event->name }}</h1>
						<h2>{{ $event->gallery }}</h2>
						
						<br>

						<div class="col-md-6 col-xs-6 text-left">
							<a href="{{ url('/adicionais/id/'. $uids->product_id ) }}"><i class="fa fa-reply"></i> SEÇÃO ANTERIOR</a>
						</div>

					</div>
					
				</div>

		    </div>

		    <br/>

			<div class="row content">

				<div class="col-md-4 col-sm-4 col-xs-12 block-left">
					<div class="col-xs-12">
						<h3><i class="fa fa-caret-right"></i> Serviço de Entrega </h3>
						<p>{{ $delivery['servico'] }}</p>
					</div>
					<div class="col-xs-12">
						<h3><i class="fa fa-caret-right"></i> Endereço de Entrega </h3>
						<p>{!! $delivery['endereco'] !!}</p>
						@if( !in_array($delivery['servico'], ['Retirar na Instituicão', 'Envio Digital']) )
							<a href="#modal-address" data-toggle="modal">
								<i class="fa fa-map-marker"></i> Alterar Endereço de Entrega.
							</a>
						@endif
					</div>
					<div class="col-xs-12">
						<h3><i class="fa fa-caret-right"></i> Observação </h3>
						<p>{{ $delivery['observacao'] }}</p>
					</div>
				</div>

				<div class="col-md-8 col-sm-8 col-xs-12 block-right">
					<div class="col-xs-12">
						<h3><i class="fa fa-list"></i> Informações do Pedido </h3>
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

					<div class="col-md-6 col-sm-6 col-xs-12 grid-cupon">
						<h3><i class="fa fa-ticket"></i> Cupom de Desconto </h3>
						<div class="form-group">
							<input placeholder="Inserir aqui" name="text-cupom" type="text" class="form-control" value="">
							<span class="help-block"></span>
						</div>
						<div class="form-group">
							<button name="btn-cupom" type="button" class="btn btn-blue">Validar Cupom</button>
						</div>
					</div>
					
					<div class="col-md-6 col-sm-6 col-xs-12 text-right">
						<br><br><br><br><br>
						<a href="#" class="btn btn-primary btn-payment" role="button">
							FINALIZAR COMPRA&nbsp;&nbsp;<i class="fa fa-share"></i>
						</a>
					</div>
				</div>

			</div>

			<div class="footer row">
			</div>

			<div class="modal fade" tabindex="-1" role="dialog" id="modal-address">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><i class="fa fa-map-marker"></i> ENDEREÇOS</h4>
						</div>
						<div class="modal-body clearfix">
	
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#lista" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
								<li role="presentation"><a href="#cadastro" aria-controls="profile" role="tab" data-toggle="tab">Cadastrar</a></li>
							</ul>

							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="lista">
									<br><br>
									<div class="col-xs-12">
										<div class="row">

											<div class="col-xs-12">

												<label for="" style="position:relative;top:-10px;">
													Selecione aqui o Endereço de Entrega!
												</label>

												<ul class="list-group">
												@if( count($alladdress) )
													@foreach( $alladdress as $item )
													<li class="list-group-item">
														<label class="radio-inline">
					  										<input type="radio" name="address" id="" value="{{ $item->id }}" {{ $item->entrega == 1 ? "checked" : "" }} />
					  										<span>{{ $item->logradouro .', '. $item->numero .' - '. $item->bairro .' - '. $item->cidade .', '. $item->estado  }} </span>
														</label>
													</li>
													@endforeach
												@endif
												</ul>
											</div>
										</div>
									</div>	
								</div>
								<div role="tabpanel" class="tab-pane" id="cadastro">
									<br>
									<div class="col-xs-12">
										<form class="formaddress">
											<div class="row">
												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for="cep">CEP: <small>*</small></label>
													<input type="text" class="form-control" name="cep">
												</div>
												<div class="col-md-8 col-sm-8 col-xs-12">
													<label for="cep">Endereço: <small>*</small></label>
													<input type="text" class="form-control" name="logradouro">
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for="">Número: <small>*</small></label>
													<input type="text" class="form-control" name="numero">
												</div>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for="">Complemento: <small>*</small></label>
													<input type="text" class="form-control" name="complemento">
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for="">Bairro: <small>*</small></label>
													<input type="text" class="form-control" name="bairro">
												</div>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for="">Cidade: <small>*</small></label>
													<input type="text" class="form-control" name="localidade">
												</div>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for="">Estado: <small>*</small></label>
													<input type="text" class="form-control" name="uf">
												</div>
											</div>
											<br>
											<!-- <div class="row">
												<div class="col-xs-12">
													<div class="checkbox">
														<label>
															<input type="checkbox" name="entrega" value="1"> Endereço de Entrega
														</label>
													</div>
												</div>
											</div> -->
										</form>
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
	
							<div class="col-xs-12">
								<div class="alert text-left" role="alert" style="display:none;"></div>
							</div>	

							<button type="button" class="btn btn-default" data-dismiss="modal">SAIR</button>
							<button type="button" class="btn btn-primary btn-modal-address">SALVAR</button>

						</div>
					</div>
				</div>
			</div>


		</div>

  	</section>

@endsection



