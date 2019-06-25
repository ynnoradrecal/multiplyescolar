<html>

	<head>
		{{--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />  --}}
		<style>

			.container{
				margin-top: 50px
			}

			.fix-margin{
				margin: 0 -15px;
				padding: 15px;
			}
			div{
				display: block;
			}

			.col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9,
			.col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9{
				float: left;
				padding: 15px 10px;
			}

			.col-sm-1, .col-md-1{
				width: 8.33333333%;
			}

			.col-sm-2, .col-md-2{
				width: 16.66666667%;
			}

			.col-sm-3, .col-md-3{
				width: 24.3333333%;
			}

			.col-md-4, .col-sm-4{
				width: 33.33333333%;
			}

			.col-sm-6, .col-md-6{
				width: 50%;
			}

			.col-sm-8, .col-md-8{
				width: 60.66666666%;
			}

			.row{
				margin-right: -15px;
    			margin-left: -15px;
				clear: both;
			}

			.clearfix{
				clear: both;
			}

			/** {
			margin: 0;
			padding: 0;
			font-size: 100%;
			font-family: 'Arial';
			line-height: 1.65; }*/

			*{
				line-height: 1.40;
			}

			img {
			max-width: 100%;
			margin: 0 auto;
			display: block; }

			body,
			.body-wrap {
			width: 100% !important;
			height: 100%;
			background: #efefef;
			-webkit-font-smoothing: antialiased;
			-webkit-text-size-adjust: none; }

			a {
			color: #71bc37;
			text-decoration: none; }

			.text-center {
			text-align: center; }

			.text-right {
			text-align: right; }

			.text-left {
			text-align: left; }

			.button {
			display: inline-block;
			color: white;
			background: #71bc37;
			border: solid #71bc37;
			border-width: 10px 20px 8px;
			font-weight: bold;
			border-radius: 4px; }

			h1, h2, h3, h4, h5, h6 {
			}

			h1 {
			font-size: 32px; }

			h2 {
			font-size: 26px; }

			h3 {
			font-size: 24px; }

			h4 {
			font-size: 20px; }

			h5 {
			font-size: 16px; }

			p, ul, ol {
			font-size: 16px;
			font-weight: normal;
			margin-bottom: 20px; }

			.container {
			display: block !important;
			clear: both !important;
			margin: 0 auto !important;
			max-width: 580px !important; }
			.container table {
				width: 100% !important;
				border-collapse: collapse; }
			.container .masthead {
				padding: 80px 0;
				background: #71bc37;
				color: white; }
				.container .masthead h1 {
				margin: 0 auto !important;
				max-width: 90%;
				text-transform: uppercase; }
			.container .content {
				background: white;
				padding: 30px 35px; }
				.container .content.footer {
				background: none; }
				.container .content.footer p {
					margin-bottom: 0;
					color: #888;
					text-align: center;
					font-size: 14px; }
				.container .content.footer a {
					color: #888;
					text-decoration: none;
					font-weight: bold; }
		</style>
	</head>

	<body style="background: #eee; color: #222">

		<table align='center' width="100%">

			<tr align='center'>

				<td align='center'>

					<table celpadding='0' width="650px" align="center" border="0" class="" style="background: #eee;">			
						<tr>				
							<td>
								<table width="100%" style="background: #5ED7BB;">
									
									<tr>
										<td style="padding: 20px 10px; min-width: 220px;">
											<img src="http://multiply.art.br/escolar/images/logo-black.png" style="max-width: 100%;" class="img-responsive" />
										</td>
										<td style="padding: 20px 10px">
											<h2 style="color: #fff; margin:0;" ><font face="arial,sans-serif">Agradecemos sua compra</font></h2>
											<p style="color: #fff; font-size: 16px; font-weight: 300; margin: 8px 0 0 0;"><font face="arial,sans-serif">Estamos esperando a confirmação de pagamento para separar seu pedido.</font></p>
										</td>
									</tr>

									<tr>
										<td colspan="2" class="text-center" style="color: #fff; background: #31C4A3; padding: 6px 0;">		
											<font face="arial,sans-serif">Olá, {{ $pedidos[0]->nome_cliente }} {{ $pedidos[0]->sobrenome_cliente }}. Segue abaixo os dados do seu pedido.</font>
										</td>
									</tr>
									
								</table>

							</td>
						</tr>
					
						<tr>
							<td>
								
								@if( count($pedidos) > 0)

									<table width="100%" style="background: #fff; padding: 15px;">
										<tr>
											<td>
												<h3 style="color: #333;"><font face="arial,sans-serif">Descrição do pedido: {{ $pedidos[0]->num_pedido }}</font></h3>
												<h5 style="margin: 0;"><font face="arial,sans-serif">Pedido criado em: {{  date('d/m/Y h:i:s', strtotime($pedidos[0]->created_at)) }}</font></h5>
											</td>
										</tr>
									</table>

									<table width="100%" cellpading="0" cellspacing="0" style="background: #fff; padding: 15px;">
										
										
										<tr style="background: #ddd;">
											<td><font face="arial,sans-serif">#</font></td>
											<td><font face="arial,sans-serif">Descrição Item</font></td>
											<td><font face="arial,sans-serif">Qtd.</font></td>
											<td><font face="arial,sans-serif">Valor Uni.</font></td>
											<td><font face="arial,sans-serif">Valor Total</font></td>
										</tr>

										@foreach ($pedidos as $pedido)

											<tr>
												<td>
													<font face="arial,sans-serif">{{ $pedido->item_id }}</font>
												</td>
												<td>
													<font face="arial,sans-serif">{{ $pedido->titulo }} {{ ($pedido->src !== null) ? '( '. $pedido->src . ' )' : '' }}</font>
												</td>
												<td class="text-center">
													<font face="arial,sans-serif">{{ $pedido->quantidade }}</font>
												</td>
												<td>
													<font face="arial,sans-serif">R$ {{  number_format( $pedido->valor_unitario , 2, ',', '.') }}</font>
												</td>
												<td>
													<font face="arial,sans-serif">R$ {{ number_format( ($pedido->valor_unitario * $pedido->quantidade) , 2, ',', '.') }}</font>
												</td>
											</tr>

										@endforeach
										
										<tr>
											<td colspan="4">
												<b><font face="arial,sans-serif">Valor total dos itens:</font></b>
											</td>								
											<td>
												<b><font face="arial,sans-serif">R$ {{ number_format($pedidos[0]->valor_pedido, 2,",",".") }}</font></b>
											</td>
										</tr>
									</table>
									<table  width="100%" cellpading="0" cellspacing="0" style="background: #fff; padding: 15px;">
										<tr>
											<td>
												<h3 style="color: #333;"><font face="arial,sans-serif">Descrição do Frete</font></h3>
												<p><font face="arial,sans-serif"><strong>Método:</strong> {{ $pedidos[0]->metodo_frete }}<br>
												<strong>Prazo:</strong> {{ $pedidos[0]->prazo_entrega }} Dias<br>
												<strong>Endereço de entrega:</strong> {{ $pedidos[0]->logradouro }}, {{ $pedidos[0]->numero }} {{ $pedidos[0]->complemento }} - {{ $pedidos[0]->bairro }} - {{ $pedidos[0]->cidade }} - {{ $pedidos[0]->estado }} - CEP: {{ $pedidos[0]->cep }}</font></p>								
											</td>
										</tr>
									</table>

								@endif

								<table  width="100%" cellpading="0" cellspacing="0" style="background: #000; color: #fff; padding: 8px; font-size: 13px;">
									<tr>
										<td class="text-center">
											<font face="arial,sans-serif">Caso você não seja a pessoa citada acima, ignore este email.</font>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>

					</table>
				</td>
			</tr>

		</table>

	</body>

</html>