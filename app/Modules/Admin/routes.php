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

Route::group(['prefix' => 'admin', 'namespace' => 'App\Modules\Admin\Controllers'], function () {
	
   
	// log
	Route::get('/', ['as' => 'admin.index', 'uses' => 'IndexController@init'])->middleware('web');
	Route::get('/forgotpassword', ['as' => 'admin.index', 'uses' => 'IndexController@index'])->middleware('web');

	Route::post('/login/init', 'IndexController@init')->middleware('web');
	Route::get('/login/out', 'IndexController@__out')->middleware('web');

	// catalogo
	Route::get('/catalogo', ['as'=>'admin.catalogo', 'uses'=>'CatalogoController@init'])->middleware('web');

	Route::group(['middleware' => ['web', 'auth.admin']], function () {

		// dashboard
		Route::get('/painel', 'DashboardController@init')->middleware('web');
		Route::post("/painel/init", 'SalesController@init')->middleware('web');

		Route::group(['prefix' => 'relatorio'],function(){
			Route::get('/visitas', ['as'=>'admin.visitas', 'uses'=>'VisitasController@init'])->middleware('web');
			Route::post('/visitas/periodo', ['as'=>'admin.visitas.periodo', 'uses'=>'VisitasController@periodo'])->middleware('web');
		});
		
		Route::get('/catalogo/fotos', 'FotosController@init')->middleware('web');
		Route::get('/fotos/show', 'FotosController@getProdutos')->middleware('web');

		Route::post('/fotos/init', 'FotosController@init')->middleware('web');
		Route::post('/fotos/upload', 'FotosController@upload')->middleware('web');

		// Politica
		Route::get('/catalogo/politica', 'PoliticaController@index')->middleware('web');
		Route::post('/politica/store', 'PoliticaController@store')->middleware('web');
		Route::get('/politica/show', 'PoliticaController@show')->middleware('web');
		Route::post('/politica/upload', 'PoliticaController@upload')->middleware('web');
		Route::post('/politica/put', 'PoliticaController@put')->middleware('web');
		Route::post('/politica/destroy', 'PoliticaController@destroy')->middleware('web');

		// Produtos 
		Route::get('/catalogo/produtos', 'ProdutosController@init')->middleware('web');
		Route::get("/product/init", "ProdutosController@init")->middleware('web');
		
		Route::post("/product/upload", "ProdutosController@upload")->middleware('web'); 
		Route::post("/product/init", "ProdutosController@save")->middleware('web');
		Route::post("/product/update", "ProdutosController@update")->middleware('web');
		Route::post("/product/delete", "ProdutosController@delete")->middleware('web');
		Route::get("/product/show", "ProdutosController@show")->middleware('web');

	  	// Events
	  	Route::get('/events', 'EventsController@init')->middleware('web');
		Route::get('/events/show', 'EventsController@getAllEvents')->middleware('web');
		Route::post('/events/init', 'EventsController@init')->middleware('web');

		// contas
		Route::get('/accounts', 'AccountsController@init')->middleware('web');
		Route::post('/accounts/store', 'AccountsController@store')->middleware('web');
		Route::post('/accounts/put', 'AccountsController@put')->middleware('web');
		Route::post('/accounts/delete', 'AccountsController@delete')->middleware('web');
		Route::post('/accounts/get', 'AccountsController@get')->middleware('web');

		Route::get('/accounts/instituicao', 'AccountsController@__get_instituicao_and_address')->middleware('web'); 
		Route::get('/accounts/alunos', 'AccountsController@__get_alunos_and_address')->middleware('web');
		Route::get('/accounts/outros', 'AccountsController@__get_clientes_and_address')->middleware('web');
		
		Route::post('/accounts/init', 'AccountsController@init')->middleware('web');


		// Métodos de Pagamento	
		Route::get('/payment-methods', ['as'=>'admin.Payment', 'uses'=>'PaymentMethodsController@init'])->middleware('web');
		Route::post('/payment-methods/init', 'PaymentMethodsController@init')->middleware('web');
		Route::post('/payment-methods/create', 'PaymentMethodsController@create')->middleware('web');
		Route::put('/payment-methods/update', 'PaymentMethodsController@update')->middleware('web');
		Route::put('/payment-methods/delete', 'PaymentMethodsController@delete')->middleware('web');
		Route::get('/payment-methods/{payment}', 'PaymentMethodsController@getPayment')->middleware('web');

		// Configurações de Loja
		Route::get('/loja', 'ConfigLojaController@init')->middleware('web');
		Route::post('/loja/init', 'ConfigLojaController@init')->middleware('web');
		Route::post('/loja/create', 'ConfigLojaController@create')->middleware('web');
		Route::put('/loja/update', 'ConfigLojaController@update')->middleware('web');
		Route::put('/loja/delete', 'ConfigLojaController@delete')->middleware('web');
		//Route::get('/loja/{slug}', 'ConfigLojaController@getConfig')->middleware('web');

		Route::get('/loja/modulos', 'ConfigLojaController@modulos')->middleware('web');
		Route::post('/loja/put', 'ConfigLojaController@put')->middleware('web');

		// Métodos de Entrega	
		Route::get('/delivery-methods', ['as'=>'admin.delivery', 'uses'=>'DeliveryMethodsController@init'])->middleware('web');
		Route::post('/delivery-methods/init', 'DeliveryMethodsController@init')->middleware('web');
		Route::post('/delivery-methods/create', 'DeliveryMethodsController@create')->middleware('web');
		Route::put('/delivery-methods/delete', 'DeliveryMethodsController@delete')->middleware('web');

		Route::get('/delivery-methods/modulos', 'DeliveryMethodsController@modulos')->middleware('web');
		Route::post('/delivery-methods/put', 'DeliveryMethodsController@put')->middleware('web');
		
		 // Método de Desenvolvedor
		Route::get('/developer', ['as'=>'admin.developer', 'uses'=>'DeveloperConfigsController@init'])->middleware('web');
		Route::post('/developer/init', 'DeveloperConfigsController@init')->middleware('web');
		Route::post('/developer/create', 'DeveloperConfigsController@create')->middleware('web');
		Route::put('/developer/update', 'DeveloperConfigsController@update')->middleware('web');
		Route::put('/developer/delete', 'DeveloperConfigsController@delete')->middleware('web');

		Route::post('/developer/upload', 'DeveloperConfigsController@upload')->middleware('web');
		Route::post('/developer/destroy', 'DeveloperConfigsController@destroyImagem')->middleware('web');
		Route::get('/developer/modulos', 'DeveloperConfigsController@modulos')->middleware('web');
		Route::post('/developer/put', 'DeveloperConfigsController@put')->middleware('web');

		Route::resource('pedidos', 'PedidosController');


		// sistema
		// Route::get('/usuarios', ['as'=>'admin.sistema', 'uses'=>'SistemaController@usuarios'])->middleware('web');

		// Sales
		Route::get("/sales/order", 'SalesController@init')->middleware('web');
		Route::get("/sales/show", 'SalesController@__get_order')->middleware('web');
		Route::post("/sales/init", 'SalesController@init')->middleware('web');


		Route::get("/sales/order-view", ['as'=>'admin.order-view', 'uses'=>'SalesController@order_view'])->middleware('web');
		Route::get("/sales/aband-cart", ['as'=>'admin.aband-cart', 'uses'=>'SalesController@aband_cart'])->middleware('web');

		// Administrativo
		

		Route::get("/administrativo/usuario", "UsuariosController@init")->middleware('web');
		Route::get("/administrativo/init", "UsuariosController@init")->middleware('web');
		Route::post("/administrativo/init", "UsuariosController@init")->middleware('web');

		Route::get("/promocoes/cupom", "PromocoesController@init")->middleware('web');
		Route::post("/promocoes/init", "PromocoesController@init")->middleware('web');

		Route::get("/administrativo/grupo", "AdministrativoController@grupo")->middleware('web');
		Route::post("/administrativo/avatar", "AdministrativoController@avatar")->middleware('web');

		// Route::post("/administrativo/init", "AdministrativoController@init")->middleware('web');


	});	

});


