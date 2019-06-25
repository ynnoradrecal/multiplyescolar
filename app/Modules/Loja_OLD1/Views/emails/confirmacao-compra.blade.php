<html>

	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<style>
			.container{
				margin-top: 50px
			}
			.fix-margin{
				margin: 0 -15px;
				padding: 15px;
			}
			h2{
				margin:0;
				padding: 0;
			}
		</style>
	</head>

	<body style="background: #eee; color: #222">

		<div class="container" style="max-width: 700px; background: #eee;">

			<div class="fix-margin" style="background: #5ED7BB;">
				<div class="row">
					<div class="col-md-4">
						<img src="http://multiply.art.br/escolar/images/logo-black.png" class="img-responsive" style="margin-top: 5px;" />
					</div>
					<div class="col-md-8">
						<h2 style="color: #fff;">Agradecemos sua compra</h2>
						<p style="color: #fff;font-size: 20px; font-weight: 300;">Nossa equipe já está separando o seu pedido!</p>
					</div>
				</div>
			</div>

			<div class="fix-margin" style="background: #fff;">
				<div class="row">
					<div class="col-sm-12">
						<div class="cart-container">
							<h3 style="color: #333;">Descrição do pedido</h3>
							
							<div class="" style="background-color: #ddd; padding: 5px 15px;">
								<div class="row">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-1">
												#
											</div>
											<div class="col-sm-5">
												Descrição Item
											</div>
											<div class="col-sm-1">Qtd.</div>
											<div class="col-sm-2">Valor Uni.</div>
											<div class="col-sm-3">Valor Total</div>
										</div>
									</div>
								</div>
							</div>
							<div class="body">
								<div class="col-sm-12">
									{{-- lista fotos em carrinho --}}
									{{--  <div class="row">
										<div class="col-sm-5">
											Fotos do evento: 
										</div>
										<div class="col-sm-2 text-center">
											{{ 5 }}
										</div>
										<div class="col-sm-2">
											R$ {{ number_format(str_replace(',','.', '50,00'), 2, ",",".") }}
										</div>
										<div class="col-sm-3">
											R$ {{ number_format( (str_replace(',','.', '50,00') * 5), 2, ",",".") }}
										</div>
									</div>  --}}

									{{-- Lista politicas em carrinho  --}}
									@foreach ($pedidos as $pedido)
										<div class="row">
											<div class="col-sm-1">
												{{ $pedido->item_id }}
											</div>
											<div class="col-sm-5">
												{{ $pedido->titulo }}
											</div>
											<div class="col-sm-1 text-center">
												{{ $pedido->quantidade }}
											</div>
											<div class="col-sm-2">
												R$ {{  number_format( $pedido->valor_unitario , 2, ',', '.') }}
											</div>
											<div class="col-sm-3">
												R$ {{ number_format( ($pedido->valor_unitario * $pedido->quantidade) , 2, ',', '.') }}
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
											<b>R$ {{ number_format($pedido->valor_pedido, 2,",",".") }}</b>
										</div>
									</div>

								</div>
								<div class="clearfix"></div>
								
							</div>
						</div>
					</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h3 style="color: #333;">Descrição do Frete</h3>

					
					<p><strong>Método:</strong> {{ $pedidos[0]->metodo_frete }}<br>
					<strong>Prazo:</strong> {{ $pedidos[0]->prazo_entrega }} Dias<br>
					<strong>Endereço de entrega:</strong> {{ $pedidos[0]->logradouro }}, {{ $pedidos[0]->numero }} {{ $pedidos[0]->complemento }} - {{ $pedidos[0]->bairro }} - {{ $pedidos[0]->cidade }} - {{ $pedidos[0]->estado }} - CEP: {{ $pedidos[0]->cep }}</p>
				</div>
			
			</div>

			<div class="order-description">

				<h1>Email enviado do site Multiply - Atendimento</h1>

				{{--  <p><strong>Nome:</strong> {{ $nome }}</p>
				<p><strong>Email:</strong> {{ $email }}</p>
				<p><strong>Assunto:</strong> {{ $assunto }}</p>
				<p><strong>Mensagem:</strong> {!! nl2br($mensagem) !!} </p>  --}}

			</div>

		</div>
		
	</body>

</html>