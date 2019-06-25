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


Route::group(['prefix' => 'beta', 'namespace' => 'App\Modules\Beta\Controllers'], function () {

	Route::get('/pagseguro/session', function () {
		return \PagSeguro::startSession();
	});

	// testes com pedidos
	Route::get('/pagseguro/session/{ref}', 'TestPagseguroController@init');


	Route::get('/pagseguro/javascript', function () {
		return file_get_contents(\PagSeguro::getUrl()['javascript']);
	});

	Route::post('/pagseguro/notification', 'PagSeguroController@init');


	Route::group(['middleware' => ['web','beta.info']], function () {

		Route::get('/', ['as' => 'beta.index', 'uses' => 'IndexController@index']);
		Route::get('/home', ['as' => 'beta.index', 'uses' => 'IndexController@index']);

		Route::post('/coupon', 'FretesController@coupon'); // validate cupom 

		// Inicio ambiente de homologação
			// Route::get('/homologacao', 'HomologacaoController@index')->name('homologacao');
			Route::get('/confirmar/fotos', 'CartController@confirmPhotos')->name('confirm-photos');
			Route::get('/show', 'CartController@addingPhotosToCart');
			Route::get('/settings-cart', 'CartController@settingsCart');
			Route::post('/cart', 'CartController@addingPhotosToCart');
			Route::post('/show', 'CartController@addingPhotosToCart');
			Route::post('/comment', 'CartController@commentPhoto');
		// Fim ambiente de homologação
		
		// login with facebook
		Route::group(['middleware' => 'carrinho.abandonado'], function () {
			Route::get('/login/facebook', 'SocialAuthController@loginWithFacebook');
			Route::get('/retorno/facebook', 'SocialAuthController@returnFromFacebook');
		});

		// rota para o login do cliente
		Route::get('/login-cadastro', ['as' => 'beta.login', 'uses' => 'IndexController@loginCadastro']); // mostra Formulário

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


		Route::group(['middleware' => ['auth.beta', 'carrinho.abandonado']], function () {

			Route::get('/email-pedido/{id}', 'IndexController@emailPedido');
		
			// gerencia a API Eventos
			Route::resource('/eventos', 'EventosController');
			Route::get('/eventos/id/{id}', 'EventosController@show');

			// checar se o PIN Existe
			Route::post('/eventos/checkPin', [
				'as' => 'update.dados.cliente', 
				'uses' => 'EventosController@checkPin'
			]);

			// gerencia galerias

			Route::get('/galerias/id/{id}', 'GaleriasController@show');
			Route::get('/galerias-json/{id}', 'GaleriasController@showJson');
			Route::get('/galerias/confirm', 'GaleriasController@confirm');

			// gerencia opcoes
			// Route::resource('/opcoes', 'PoliticasController');

			Route::get('/adicionais/shows', 'PoliticasController@showPolicys');
			Route::get('/adicionais/id/{id}', [
				'as' => 'opcoes.index',
				'uses' => 'PoliticasController@show'
			]);

			// gerencia tipo de produto digital/impresso
			Route::get('/midia-digital/{id}', [
				'as' => 'midia.digital',
				'uses' => 'ArquivosDigitaisController@index'
			]);
			Route::post('/midia-digital/{id}', 'ArquivosDigitaisController@saveCLientData');

			Route::get('/frete', ['as' => 'frete.index','uses' => 'FretesController@index']);
			Route::post('/frete/new-address', 'FretesController@newAddress');
			Route::post('/frete/change-address-delivery', 'FretesController@changeAddressDelivery');
			Route::post('/frete/finalize-payment', 'FretesController@finalizePayment');

			Route::get('/frete/confirmacao', [
				'as' => 'frete.confirmacao',
				'uses' => 'FretesController@confirma'
			]);


			// adiciona imagens ao carrinho de compra
			Route::post('/add-to-cart/images', 'CartController@addPhotosToCart');

			// adiciona imagens ao carrinho de compra
			Route::get('/add-to-cart/images', 'CartController@recuperaCarrinho');


			// adiciona imagens ao carrinho de compra
			Route::post('/add-to-cart/options', 'CartController@addOptionsToCart');


			// adiciona dados do frete ao carrinho de compra
			Route::post('/add-to-cart/frete', 'CartController@addFreteToCart');
			Route::get('/checkout', 'CartController@checkout');
			Route::post('/checkout/payment', 'CartController@payment');


			// Route::post('/add-to-cart/frete/endereco', 'FretesController@addEndereco');
			Route::post('/add-to-cart/frete/endereco', [
				'as' => 'add.endereco.frete',
				'uses' => 'FretesController@addEndereco'
			]);


			Route::post('realiza-pagamento', 'CartController@buildPayment' );
			Route::post('realiza-pagamento-gratis', 'CartController@buildFreePayment' );


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

			Route::get('/minha-conta/endereco/{id}/delete', [
				'as' => 'delete.endereco',
				'uses' => 'ClientesController@deletaEndereco'
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
				'uses' => 'PedidosController@listPedidos'
			]);

			Route::get('/minha-conta/{cliente_id}/pedido/{pedido_id}/{ref}', [
				'as' => 'detalhe.pedido', 
				'uses' => 'PedidosController@showPedido'
			]);

			Route::post('checa-carrinho', 'IndexController@ifExistsCart');
			Route::get('kill-cart', 'CartController@killSessionCart');

			Route::post('pagseguro-error', 'PagseguroErrorsController@index');
		
		});

	}); // fim do group Web

}); // fim do gorup Modules Loja
