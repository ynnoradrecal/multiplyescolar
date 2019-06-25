<html>

	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	</head>

	<body style="background: #fff; color: #222">

		<div class="container">

			<h1>Email enviado do site Multiply - Atendimento</h1>

			<p><strong>Nome:</strong> {{ $nome }}</p>
			<p><strong>Email:</strong> {{ $email }}</p>
			<p><strong>Assunto:</strong> {{ $assunto }}</p>
			<p><strong>Mensagem:</strong> {!! nl2br($mensagem) !!} </p>

		</div>
		
	</body>

</html>