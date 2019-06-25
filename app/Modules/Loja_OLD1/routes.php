<?php
/*
|--------------------------------------------------------------------------
| ModuleOne Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the ModuleOne module have to go in here. Make sure
| to change the namespace in case you decide to change the
| namespace/structure of controllers.
|
*/


Route::group(['prefix' => '', 'namespace' => 'App\Modules\Loja\Controllers'], function () {

	Route::get('/pagseguro/session', function () {
		return \PagSeguro::startSession();
	});

	Route::get('/pagseguro/javascript', function () {
		return file_get_contents(\PagSeguro::getUrl()['javascript']);
	});

	Route::post('/pagseguro/notification', 'PagSeguroController@init');

	Route::group(['middleware' => ['web','loja.info']], function () {

		// login with facebook
		Route::get('/login/facebook', 'SocialAuthController@loginWithFacebook');
		Route::get('/retorno/facebook', 'SocialAuthController@returnFromFacebook');		

		Route::get('/', ['as' => 'loja.index', 'uses' => 'IndexController@index']);
		Route::get('/home', ['as' => 'loja.index', 'uses' => 'IndexController@index']);

		// rota para o login do cliente
		Route::get('/login-cadastro', ['as' => 'loja.login', 'uses' => 'IndexController@loginCadastro']); // mostra Formulário

		Route::post('/login', [
			'as' => 'login.cliente',
			'uses' => 'ClientesLoginController@clienteLoginPost'
		]);

		Route::get('/logout', ['as' => 'logout.cliente', 'uses' => 'ClientesLoginController@clienteLogout']);

		// Recebe formulário  de cadastro
		Route::post('/cadastro', [
			'as' => 'cadastrar.cliente', 
			'uses' => 'ClientesController@storeClientSoft'
		]);

		// mostra página de contato
		Route::get('/contato', 'IndexController@contato');

		// realiza o envio de email
		Route::post('/contato', 'IndexController@sendEmail');


		Route::group(['middleware' => 'auth.cliente'], function () {
		
			// gerencia a API Eventos
			Route::resource('/eventos', 'EventosController');

			// checar se o PIN Existe
			Route::post('/eventos/checkPin', [
					'as' => 'update.dados.cliente', 
					'uses' => 'EventosController@checkPin'
			]);

			// gerencia galerias
			Route::resource('/galerias', 'GaleriasController');

			Route::get('/galerias/confirm', 'GaleriasController@confirm');

			// gerencia opcoes
			Route::resource('/opcoes', 'PoliticasController');
			Route::get('/opcoes/{id}', [
				'as' => 'opcoes.index',
				'uses' => 'PoliticasController@show'
			]);

			// gerencia tipo de produto digital/impresso
			Route::get('/midia-digital/{id}', [
				'as' => 'midia.digital',
				'uses' => 'ArquivosDigitaisController@index'
			]);
			Route::post('/midia-digital/{id}', 'ArquivosDigitaisController@saveCLientData');

			Route::get('/frete', [
				'as' => 'frete.index',
				'uses' => 'FretesController@index'
			]);

			Route::get('/frete/confirmacao', [
				'as' => 'frete.confirmacao',
				'uses' => 'FretesController@confirma'
			]);


			// adiciona imagens ao carrinho de compra
			Route::post('/add-to-cart/images', 'CartController@addPhotosToCart');


			// adiciona imagens ao carrinho de compra
			Route::post('/add-to-cart/options', 'CartController@addOptionsToCart');


			// adiciona dados do frete ao carrinho de compra
			Route::post('/add-to-cart/frete', 'CartController@addFreteToCart');


			// Route::post('/add-to-cart/frete/endereco', 'FretesController@addEndereco');
			Route::post('/add-to-cart/frete/endereco', [
				'as' => 'add.endereco.frete',
				'uses' => 'FretesController@addEndereco'
			]);


			Route::post('realiza-pagamento', 'CartController@buildPayment' );


			// rotas protegidas por login usarão a middleware('auth.cliente')
			Route::get('/minha-conta', [
				'as' => 'area.cliente',
				'uses' => 'ClientesController@showDadosCliente'
			]);


			Route::get('/minha-conta/dados-cadastrais', [
				'as' => 'show.dados.cliente',
				'uses' => 'ClientesController@showDadosCliente'
			]);


			Route::post('/minha-conta/dados-cadastrais', [
				'as' => 'update.dados.cliente', 
				'uses' => 'ClientesController@updateDadosCliente'
			]);


			Route::get('/minha-conta/{id_usuario}/enderecos', [
				'as' => 'list.enderecos',
				'uses' => 'ClientesController@listEnderecos'
			]);

			Route::get('/minha-conta/endereco/{id}', [
				'as' => 'show.edit.endereco',
				'uses' => 'ClientesController@showEndereco'
			]);

			Route::put('/minha-conta/endereco/{id}', [
				'as' => 'show.edit.endereco',
				'uses' => 'ClientesController@atualizaEndereco'
			]);

			Route::get('minha-conta/{user_id}/endereco/principal/{endereco_id}', 'ClientesController@alteraEnderecoPrincipal');


			Route::get('/minha-conta/cadastra-endereco', [
				'as' => 'form.add.endereco', 
				'uses' =>'ClientesController@showCadastroEndereco'
			]);

			Route::post('/minha-conta/cadastra-endereco', [
				'as' => 'form.add.endereco', 
				'uses' =>'ClientesController@cadastraEndereco'
			]);

			// Route::post('/minha-conta/atualiza-endereco', [
			// 	'as' => 'form.add.endereco', 
			// 	'uses' =>'ClientesController@cadastraEndereco'
			// ]);


			Route::get('/minha-conta/atendimento', [
				'as' => 'show.atendimento', 
				'uses' => 'ClientesController@showAtendimento'
			]);


			Route::post('/minha-conta/atendimento', [
				'as' => 'save.atendimento', 
				'uses' => 'IndexController@sendEmail'
			]);

			Route::get('/minha-conta/{cliente_id}/pedidos', [
				'as' => 'lista.pedidos', 
				'uses' => 'ClientesController@listPedidos'
			]);

			Route::get('/minha-conta/{cliente_id}/pedido/{pedido_id}/{ref}', [
				'as' => 'detalhe.pedido', 
				'uses' => 'ClientesController@showPedido'
			]);
		
		});

	}); // fim do group Web

}); // fim do gorup Modules Loja
