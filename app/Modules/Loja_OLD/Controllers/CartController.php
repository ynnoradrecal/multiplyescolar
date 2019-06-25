<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Facades
use Mail;
use Session;
use DB;
use URL;
use Auth;
use PagSeguro;

// models
use App\Models\Cart;
use App\Models\Pedido;
use App\Models\ItensPedido;
use App\Models\AbandonedCart;

// Helpers
use Carbon\Carbon;



class CartController extends Controller
{


	public $politicas = [];

	// adiciona imagens dentro da session
	public function addPhotosToCart(Request $request)
	{
		// declaração de variáveis
		$j = 0; $imagens = [];

		// verifica se existe variavel de confirmação
		// caso exista este request veio da tela de confirmação de fotos
		if( $request->input('confirmacao') === null ){

			// if(!Session::has('utils')){			

			// 	$repositorios = DB::table('events')
			// 	->where('events.id', '=', $request->input("produto_id"))
			// 	->join('produtos as prod', 'events.id', '=', 'prod.event_id')
			// 	->leftJoin('alunos', 'prod.aluno_id', '=', 'alunos.id')
			// 	->select( 'alunos.nome as nome_aluno', 'prod.nome as product_name', 'prod.id', 'prod.created_at as prod_data', 'prod.pin')
			// 	->get();

			// 	dd( $request->input("produto_id") );

			// 	if( isset( $repositorios[0]->aluno_id)  ){
			// 		$aluno_id = $repositorios[0]->aluno_id;
			// 	}else{
			// 		$aluno_id = 0;
			// 	}
				 
			// 	$utils = [
			// 		'evento_id' => $repositorios[0]->event_id,
			// 		'aluno_id' => $aluno_id,
			// 		'produto_id' => $repositorios[0]->id
			// 	];

			// 	$request->session()->put('utils', $utils );
			// }


			// recupera instancia de carrinho, caso exista
			$oldCart = Session::has('cart') ? Session::get('cart') : null;

			// recupera dados do cliente para adicionar a session
			$cliente = Auth::guard('cliente')->user();

			// recupera id do cliente logado
			$idUser = $cliente->id;

			// recupera array de imagens
			$reqImagens = $request->input('imagem');

			// busca todos os endereços do cliente logado
			$enderecos = DB::table('rel_conts_ends')
						->where([
							['rel_conts_ends.id_conta', '=', $idUser],
							['rel_conts_ends.tipo_de_conta', '=', 'cliente']
						])
						->join('enderecos as end', 'end.id', '=', 'rel_conts_ends.id_endereco')
						->select('end.*')
						->get();
			
			//  adiciona enderecos ao objeto clientes
			$cliente->enderecos = $enderecos;

			// verifica os ids selecionados pelo cliente
			// filtra as imagens selecionadas pelo cliente na tela anterior
			for($i = 0; $i < count($reqImagens); $i++){

				// caso exista o campo id no meu array, ele adiciona a minha lista de imagens em session
				if (array_key_exists('id',$reqImagens[$i])) {
					$imagens[$j] = $reqImagens[$i];
					$j++;
				}

			}// endfor

			if($j == 0){
				return redirect()->back()->withErrors(['message' => 'Escolha ao menos uma foto para prosseguir']);
			}

			// caso já existam imagens em session, zera os dadose retira os valores
			// código para corrigir erro de contagem duplicada das imagens, caso o usuário volte uma página via navegador
			if( isset($oldCart->imagens) ){
				
				// conta as imagens existentes em session
				$numImagens = count($oldCart->imagens);

				// multiplica numero de imagens pelo valor unitário
				$valTotImagens = $oldCart->precoUnidadeImagem * $numImagens;

				// retira o valor das imagens do preço total e atualiza o valor tiotal do pedido
				$oldCart->precoTotal = $oldCart->precoTotal - $valTotImagens;

				// zera objeto de imagens dentro da session
				$oldCart->imagens = [];
			}

			// cria instancia de carrinho
			$cart = new Cart( $oldCart );

			// adiciona dados de cliente ao carrinho
			$cart->addCliente( $cliente );

			// adiciona ao carrinho todas imagens escolhidas pelo cliente
			$cart->addImagens( $imagens );

			// just return true
			$cart->genTotalValueImages( $request->input('produto_id') );

			// insere na sessão o objeto de Carrinho Cart::all()
			$request->session()->put( 'cart', $cart );

			// recebe a página originadora do request
			$pagAnterior = URL::previous();

			// get Session Object
			$session = $request->session();

			// salva a sessão no banco de dados
			$this->saveCartSession( $session, $idUser, $pagAnterior );

			$clean = array();

			// recupera url das imagens para passar para a view
			for($i = 0; $i < count($cart->imagens); $i++){
				$clean[$i] = DB::table('fotos_produto')->where('id', '=', $cart->imagens[$i]['id'])->select('url')->first();
				$request->session()->get('cart')->imagens[$i]['url'] = $clean[$i]->url;
			}

			// transforma retorno em objeto
			$galeria = json_decode( json_encode($request->session()->get('cart')->imagens, false) );

			return view("Loja::loggedin.galeria-confirm",compact('galeria'));


		}else{		

			$reqImagens = $request->input("imagem");

			for($i = 0; $i < count($reqImagens); $i++){

				// caso exista o campo id no meu array, ele adiciona a minha lista de imagens em session
				if (array_key_exists('id',$reqImagens[$i])) {
					$imagens[$j] = $reqImagens[$i];
					$j++;
				}

			}// endfor

			$numOldImages = count($request->session()->get('cart')->imagens);
			$numAtualImages = count($imagens);

			// caso o usu[ário tenha excluido alguma imagem, atualiza valor com novas imagens
			if( $numAtualImages != $numOldImages ){
				
				$imgenUnidade = $request->session()->get('cart')->precoUnidadeImagem;
				
				$precoTotal = $request->session()->get('cart')->precoTotal;

				$precoAtualizado = ($precoTotal - ($numOldImages * $imgenUnidade)) + ($numAtualImages * $imgenUnidade);

				$request->session()->get('cart')->precoTotal = $precoAtualizado;
			}

			// adiciona novas images asession
			$request->session()->get('cart')->imagens = $imagens;

			return redirect("opcoes/".$request->session()->get('utils')['produto_id']);
			
		}

	} // end addPhotosToCart()


	// método para persistencia dos dados
	public function saveCartSession($session, $idUser, $url = null)
	{

		// seleciona Session
		$cartSession = AbandonedCart::where([
			['cliente_id', '=', $idUser],
			['status', '=', 1]
		])->get();

		// caso sessão exista, atualiza os dados de carrinho abandonado
		if( count($cartSession) > 0 ){
			$cart = AbandonedCart::find( $cartSession[0]->id );

			// faz a atualização dos dados
			$cart->update([
				'session' => json_encode($session->get('cart')),
				'url' => $url
			]);

		}else{ // caso não exista, cria uma nova

			// cria uma nova linha no banco de dados
			$create = AbandonedCart::create([
				'session' => json_encode( $session->get('cart') ),
				'cliente_id' => $idUser
			]);
		}

		return true;

	} //end saveCartSession()


	// método gerenciador de politicas
	public function addOptionsToCart(Request $request)
	{
		$politicas = $request->input('politicas');
		$radios = $request->input('radio');
		$politicasCart = [];
		$counter = 0;

		for( $i = 0; $i < count($politicas); $i++ ){

			if( array_has( $politicas[$i], 'option' ) ){
				
				foreach($politicas[$i] as $key => $value){
					$politicasCart[$counter][$key] = $value;
				}

				$counter++;

			}else{

				if( count($radios) > 0 ){
					foreach($radios as $radio ){
						
						if($radio == $i ){

							foreach($politicas[$i] as $key => $value){
								$politicasCart[$counter][$key] = $value;
							}

							$counter++;
						}
					}
				}
			}
		}

		// recupera instancia de carrinho, caso exista dentro da Session
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		
		// caso o usuário volte um passo via navegador, retira a soma inseria antes de ele voltar o passo
		if( count($oldCart->politicas) > 0 ){
			
			$valorPoliticas = 0;
			
			for($i = 0; $i < count($oldCart->politicas); $i++ ){
				$valorPoliticas += $oldCart->politicas[$i]['preco'];
			}
			$oldCart->precoTotal = ($oldCart->precoTotal - $valorPoliticas);
		}

		// cria instancia de carrinho
		$cart = new Cart( $oldCart );

		// adiciona ao carrinho todas politicas escolhidas pelo cliente
		$cart->addPoliticas( $politicasCart );

		// cria instancia de carrinho dentro da session
		$request->session()->put( 'cart', $cart );

		// recupera id do cliente para inserção na session
		$idUser = Auth::guard('cliente')->user()->id;

		// recebe a página originadora do request
		$pagAnterior = URL::previous();

		// get Session Object
		$session = $request->session();

		// salva a sessão no banco de dados
		$this->saveCartSession( $session, $idUser, $pagAnterior );

		return redirect()->route("frete.index");
	}


	// adiciona frete ao carrinho de compra
	public function addFreteToCart(Request $request)
	{
		$this->validate($request, [
			'prazo' => 'required',
			'valor' => 'required',
			'cep' => 'required',
			'endereco_id' => 'required'
		]);

		$frete = [
			'prazo' => $request->input("prazo"),
			'valor' => $request->input("valor"),
			'cep' => $request->input("cep"),
			'endereco_id' => $request->input("endereco_id")
		];
		$request->session()->get("cart")->frete = $frete;
		$cart = $request->session()->get("cart");
		$utils = json_decode(json_encode($request->session()->get("utils"), false));

		return view("Loja::loggedin.finaliza-compra", compact("cart","utils"));
		
	}


	public function buildPayment(Request $request)
	{

		$cart = $request->session()->get("cart");

		$itens = $endereco = [];
		$contador = 0;

		// insere imagens dentro de itens
		for($i = 0; $i < count($cart->imagens); $i++){
			$itens[$i] = [
				'itemId' => $cart->imagens[$i]['id'],
				'itemDescription' => 'Foto',
				'itemAmount' => str_replace( ',', '.', $cart->precoUnidadeImagem ),
				'itemQuantity' => '1'
			];
		}

		// contador de politicas
		$contador = count($itens);

		// insere politicas dentro de itens
		for($j = 0; $j < count($cart->politicas); $j++){
			$itens[$contador] = [
				'itemId' => $cart->politicas[$j]['politica_id'],
				'itemDescription' => $cart->politicas[$j]['titulo'],
				'itemAmount' => str_replace( ',', '.', $cart->politicas[$j]['preco'] ),
				'itemQuantity' => '1'
			];
			$contador++;
		}

		// indere endereço escolhido pelo cliente
		for($i = 0; $i < count($cart->cliente->enderecos); $i++){
			
			if( $cart->frete['endereco_id'] == $cart->cliente->enderecos[$i]->id){

				$endereco['shippingAddressStreet'] = $cart->cliente->enderecos[$i]->logradouro;
				$endereco['shippingAddressNumber'] = $cart->cliente->enderecos[$i]->numero;
				$endereco['shippingAddressDistrict'] = $cart->cliente->enderecos[$i]->bairro;
				$endereco['shippingAddressPostalCode'] = $cart->cliente->enderecos[$i]->cep;
				$endereco['shippingAddressCity'] = $cart->cliente->enderecos[$i]->cidade;
				$endereco['shippingAddressState'] = 'SP';
			}

		}

		$idPedido = $cart->cliente->id.date('dmy').rand(1000, 9999);

		try {
    		//chamar os métodos da bilbioteca aqui dentro

			$telefone =  (strlen(trim($cart->cliente->telefone)) < 10 ) ? $cart->cliente->telefone : $cart->cliente->celular;

			$pagseguro = PagSeguro::setReference($idPedido)
				->setSenderInfo([
					'senderName' =>  $cart->cliente->name .' '. $cart->cliente->last_name, //Deve conter nome e sobrenome
					'senderPhone' => $telefone, //Código de área enviado junto com o telefone
					'senderEmail' => 'c79107725014943159091@sandbox.pagseguro.com.br',
					'senderHash' => $request->input('senderHash'),
					'senderCPF' => $cart->cliente->cpf //Ou CNPJ se for Pessoa Júridica
				])
				->setCreditCardHolder([
					'creditCardHolderName' =>  $cart->cliente->name .' '. $cart->cliente->last_name, //Deve conter nome e sobrenome
					'creditCardHolderPhone' => $telefone, //Código de área enviado junto com o telefone
					'creditCardHolderCPF' => $cart->cliente->cpf, //Ou CNPJ se for Pessoa Júridica
					'creditCardHolderBirthDate' => '10/12/1988',
				])
				->setShippingAddress($endereco)
				->setBillingAddress($endereco)
				->setItems(
					$itens
				)
				->setShippingInfo([
					'shippingType' => '1', //: 1 – PAC, 2 – SEDEX, 3 - Desconhecido
					'shippingCost' => str_replace( ',', '.', $cart->frete['valor'] )
				])
				->send([
					'paymentMethod' => 'creditCard',
					'creditCardToken' => $request->input('token'),
					'installmentQuantity' => ($request->input('parcelas') > 0) ? $request->input('parcelas') : 1,
					'installmentValue' => (str_replace( ',', '.', $request->input('valor_parcela')) == 0.00) ? str_replace( ',', '.', $request->input('valorTotal')) : str_replace( ',', '.', $request->input('valor_parcela')),
					'noInterestInstallmentQuantity' => 0 // numero de parcelas descontos
				]);
		}
		catch(\Artistas\PagSeguro\PagSeguroException $e) {
			
			$error =[ 
				'error' => [
					'code' => $e->getCode(), 
					'message' => $e->getMessage()
				]
			];

			return json_encode($error,false);
		}

		$paymentData = json_encode($pagseguro);
		// $retornoPagSeguro = json_decode($paymentData, false)

		// invoca construtor de pedidos
		$this->buildOrder($idPedido, json_decode($paymentData, false), $request, $itens);

		// deleta carts da session
		$request->session()->forget('cart');

		// deleta utils da session
		$request->session()->forget('utils');

		// retorna todos os dados da compra
		return $paymentData;
	}


	// constroi pedido
	protected function buildOrder($numPedido, $payment, $request, $itens)
	{

		$cart = $request->session()->get("cart");
		$utils = $request->session()->get("utils");

		$pedido = Pedido::create([
			'num_pedido' => $numPedido,
			'endereco_id' => $cart->frete['endereco_id'],
			'code_transacao' => $payment->code,
			'valor_frete'	=> $cart->frete['valor'],
			'prazo_entrega' => $cart->frete['prazo'],
			'referencia' =>  $payment->reference,
			'cliente_id' => $cart->cliente->id,
			'valor_pedido' => $payment->grossAmount,
			'status' => $payment->status,
			'total_parcial' => $payment->netAmount,
			'tipo_pagamento' => $payment->type
		]);

		for($i = 0; $i < count($cart->imagens);$i++){
			$item = [
				'pedido_id' => $pedido->id,
				'produto_id' => $utils['produto_id'],
				'item_id' => $cart->imagens[$i]['id'],
				'quantidade' => 1,
				'valor_unitario' => $cart->precoUnidadeImagem,
				'descricao' => $cart->imagens[$i]['mensagem'],
				'titulo' => 'Foto'
			];
			ItensPedido::create($item);
		}

		for($i = 0; $i < count($cart->politicas);$i++){
			$item = [
				'pedido_id' => $pedido->id,
				'produto_id' => $utils['produto_id'],
				'item_id' => $cart->politicas[$i]['politica_id'],
				'quantidade' => 1,
				'valor_unitario' =>$cart->politicas[$i]['preco'],
				'descricao' => 'politica',
				'titulo' => 'Opcionais: '. $cart->politicas[$i]['titulo']
			];
			ItensPedido::create($item);
		}

		// insere todos os retornos do pagseguro para validação posterior
		DB::table('transaction_pagseguro')->insert([
			'pedido_id' => $pedido->id, 
			'pedido_code' => $numPedido,
			'json' => json_encode($payment)
		]);

		return true;

	}


}
