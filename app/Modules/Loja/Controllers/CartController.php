<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Loja\Helpers\EmailHelper;

// Facades
use Mail;
use Session;
use DB;
use URL;
use Auth;
use PagSeguro;
use Response;

// models
use App\Models\Cart;
use App\Models\Pedido;
use App\Models\ItensPedido;
use App\Models\AbandonedCart;

// Helpers
use Carbon\Carbon;

// ##devynnor##################################
// services

// Serviço de auxilio para adicionar fotos no carrinho
use App\Modules\Loja\Services\Cart as SCart; 
use App\Modules\Loja\Services\SPagSeguro as SPag;
// ##devynnor##################################

class CartController extends Controller
{
	public $politicas = [];

	// ##devynnor##################################
	// Mudançãs no codigo. Outras forma de adicionar fotos no carrinho usando "JqueryAjax"
	// Inicio da codificação
	
	private $req;

    private $scart;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( Request $req ) 
    {

        $this->req = $req;
        $this->scart = new SCart( $req );

        // $this->scart->__clean();
    }

	public function addingPhotosToCart() // adicionando fotos no carrinho
	{
		$method = $this->req->input('methods'); // method
		$cart   = $this->scart;
		
        if( empty($method) ) {
            $exists = Session::has('scart'); // exists cart
            // verify exists cart
            if( !$exists ) {
                return $cart->__add( 'fotos' ); // adicionar
            }else{
                return $cart->__up( $this->req, 'fotos' ); // atualizar
            }
        }else{
            if( $method == 'show' ) { // marcar imagens ja selecionada na view
                return $cart->__show();
            }
            if( $method == 'del' ) {
                return $cart->__del_item( 'fotos' );
            }
        }  


	}

	public function commentPhoto() 
    {

        $cart    = Session::get('scart'); $key = 'imagens';
        $comment = $this->req->input('mensagem');
        $index   = $this->scart->exists_id( $comment['id'], $key );

        if( strlen($index) != 0 ) {
            $cart[$key][$index]['mensagem'] = $comment['mensagem'];
            $this->req->session()->put(array(
                'scart' => $cart
            ));
            return array(
                'status' => 'success',
                'action' => 'comment'
            );
        }
    }

	public function confirmPhotos() // confirmarção das fotos selecionadas
	{

		$cart   = Session::get('scart'); $key = 'imagens';
		$nucleo = Session::get('nucleo');

		$event = (object) $nucleo['event']; 
		$uids  = (object) $nucleo['uids'];

		return view('Loja::loggedin.galeria-confirm', array(

            'data'            => $cart[$key],
            'id_galeria'      => $uids->product_id,
            'nome_do_evento'  => $event->name,
            'nome_da_galeria' => $event->gallery
            
        ));

	}

	public function settingsCart() 
	{
		$old_cart = 0;
		$cliente  = Auth::guard('cliente')->user();
		$nucleo   = Session::get('nucleo');

		$event    = (object) $nucleo['event'];
		$uids     = (object) $nucleo['uids'];

		$scart    = Session::get('scart');
		
		if(count(Session::get('scart')['imagens']) == 0)
			return redirect( url('/') .'/galerias/'. $uids->product_id );

		$cliente->enderecos = $this->getAddressClient($cliente->id);

		Session::put('cart', []); // default carrinho sempre iniciar zerado.
		
		$cart = new Cart( $old_cart );
		
		$cart->addCliente( $cliente ); // dados do cliente
		$cart->addImagens( $this->getOnlyIdMessage('imagens') );
		$cart->genTotalValueImages( $uids->product_id );

		$nucleo['imagens'] = $scart['imagens'];

		Session::put( 'cart', $cart );
		Session::put( 'nucleo', $nucleo );
		
		// $this->saveCartSession($cliente->id);

		return redirect("adicionais/id/" . $uids->product_id );

	}

	public function getOnlyIdMessage( $key ) {

		$exists = Session::has('scart');
		$images = [];

		if( $exists ) {

			$scart = Session::get('scart');
			
			foreach( $scart[$key] as $item ) {
				$images[] = array(
					'id' => $item['id'],
					'mensagem' => isset($item['mensagem']) ? $item['mensagem'] : ''
				);
			}
		}

		return $images;

	}

	public function getAddressClient( $id ) 
	{
		return DB::table('rel_conts_ends')
			->where([
				['rel_conts_ends.id_conta', '=', $id],
				['rel_conts_ends.tipo_de_conta', '=', 'cliente']
			])
		->join('enderecos as end', 'end.id', '=', 'rel_conts_ends.id_endereco')
		->select('end.*')->get();

	}

	public function filterSession( $data ) { // filtrar dados da session antes de salvar

		$cont = 0;

		foreach( $data as $i => $item ) {
			if(!empty($data[$i])) {
				$cont++;
			}
		}

		if($cont == 7) {
			return $data;
		}

		return array();

	}

	public function checkout() 
	{

		$nucleo  = Session::get('nucleo');
		$cart    = Session::get('cart');

		$product = \App\Models\Produtos::where('id', $nucleo['uids']['product_id'])->first();
		$info    = SCart::info_cart( $product );
		$event   = (object) $nucleo['event'];

		$address = DB::table('rel_conts_ends')->where('id_conta', $cart->cliente->id)
		->leftJoin('enderecos', 'rel_conts_ends.id_endereco', '=', 'enderecos.id')
		->where('entrega', 1)->select('enderecos.*')->first();

		$client = DB::table('clientes')->where('id', $cart->cliente->id)->first();

		if( $nucleo['event']['total'] != 0 ) {
			return view("Loja::loggedin.finaliza-compra", compact('cart', 'info', 'address', 'client', 'event'));
		}

		else{
			return view("Loja::loggedin.finaliza-compra-gratis", compact("cart"));
		}

	}
	
	// Fim da codificação
	// ##devynnor##################################

	// adiciona imagens dentro da session
	public function addPhotosToCart(Request $request)
	{
		// declaração de variáveis
		$j = 0; $imagens = [];

		// verifica se existe variavel de confirmação
		// caso exista este request veio da tela de confirmação de fotos
		if( $request->input('confirmacao') === null ){
			dd('opa');
			//dd( Session::get('utils') );		

			if(!Session::has('utils')){			
				
				$repositorios = DB::table('events')

				->where('events.id', '=', $request->input("produto_id"))
				->join('produtos as prod', 'events.id', '=', 'prod.event_id')
				->leftJoin('alunos', 'prod.aluno_id', '=', 'alunos.id')
				->select( 'events.parcelas', 'alunos.nome as nome_aluno', 'prod.nome as product_name', 'prod.id', 'prod.created_at as prod_data', 'prod.pin')
				->get();

				if( isset( $repositorios[0]->aluno_id)  ){
					$aluno_id = $repositorios[0]->aluno_id;
				}else{
					$aluno_id = 0;
				}
				 
				$utils = [
					'evento_id' => $repositorios[0]->event_id,
					'aluno_id' => $aluno_id,
					'produto_id' => $repositorios[0]->id,
					'parcelas_sem_juros' => $repositorios[0]->parcelas
				];

				$request->session()->put('utils', $utils );
			}
			

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
			//$this->saveCartSession( $session, $idUser, $pagAnterior );

			$clean = array();
			
			// recupera url das imagens para passar para a view
			for($i = 0; $i < count($cart->imagens); $i++){
				$clean[$i] = DB::table('fotos_produto')->where('id', '=', $cart->imagens[$i]['id'])->select('url')->first();
				$request->session()->get('cart')->imagens[$i]['url'] = $clean[$i]->url;
			}

			// transforma retorno em objeto
			$galeria = json_decode( json_encode($request->session()->get('cart')->imagens, false) );

			$idUser = Auth::guard('cliente')->user()->id;			

			$teste  = $this->saveCartSession( $idUser );

			return view("Loja::loggedin.galeria-confirm", compact('galeria'));

		}else{
			
			dd('ola');

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

			// caso o usuário tenha excluido alguma imagem, atualiza valor com novas imagens
			if( $numAtualImages != $numOldImages ){
				
				$imgenUnidade = $request->session()->get('cart')->precoUnidadeImagem;
				
				$precoTotal = $request->session()->get('cart')->precoTotal;

				$maxImagesDesconto = $request->session()->get('cart')->maxImagesDesconto;

				$precoAtualizado = ($precoTotal - ($numOldImages * $imgenUnidade)) + ($numAtualImages * $imgenUnidade);

				if( $maxImagesDesconto < $numAtualImages){
					$valDesconto = ($maxImagesDesconto * $imgenUnidade);
				}else{
					$valDesconto = ($numAtualImages * $imgenUnidade);
				}				

				if( $precoAtualizado < 0 ){
					$precoAtualizado = 0.00;
				}

				$request->session()->get('cart')->valDesconto = $valDesconto;
				$request->session()->get('cart')->precoTotal = $precoAtualizado;
			}

			$cart = $request->session()->get('cart');

			// caso não existam imagens, redireciona a galeria
			if(count($cart->imagens) == 0){
				$utils = json_decode(json_encode($request->session()->get('utils')), false);
				$request->session()->forget('cart');
				return redirect( 'galerias/' . $utils->produto_id );		
			}

			// adiciona novas images a session
			$request->session()->get('cart')->imagens = $imagens;

			//
			$idUser = Auth::guard('cliente')->user()->id;

			$json = $request->session();
			
			$this->saveCartSession( $idUser );

			$utils =  json_decode(json_encode($request->session()->get('utils')), true);		

			return redirect("opcoes/" . $utils['produto_id'] );

			// gerencia pagina de escolha de impresso ou digital
			//$util = json_decode(json_encode($request->session()->get('utils')), false);		
			//return view("Loja::loggedin.tipo-produto", compact("util"));
			
		}

	} // end addPhotosToCart()


	// método para persistencia dos dados
	public function saveCartSession( $id )
	{

		$utils = Session::get('utils');
		$cart  = AbandonedCart::where('produto_id', $utils['produto_id'])->first();

		if( empty($id) ) { // ativar apenas quando finalizar compra

			AbandonedCart::where('session_id', Session::get('session_id'))
          		->update(['status' => 0]);

		}

		if( !empty($cart) && $utils['produto_id'] == $cart->produto_id && $cart->session_id  == Session::get('session_id') ) {

			AbandonedCart::where('session_id', Session::get('session_id'))
          		->update(['url' => url()->current()]);

		}else{
			
			$data = $this->filterSession(array(
				'session_id' => Session::get('session_id'),
				'cliente_id' => $id,
				'produto_id' => $utils['produto_id'],
				'session'    => json_encode(Session::get('scart')),
				'utils'      => json_encode(Session::get('utils')),
				'url'        => url()->current(),
				'status'     => 1
			));

			if( count($data) != 0 ) {
				AbandonedCart::create($data);
			}
			

		}
	

	} //end saveCartSession()


	// método gerenciador de politicas
	public function addOptionsToCart(Request $request)
	{

		$spolicys = []; $uids = [];

		$nucleo = Session::get('nucleo');
		
		$nucleo['policys'] = [];

		$uids = array_map(function($item) {
			return $item['id'];
		}, $request->input('policys'));

		foreach( $request->input('policys') as $i => $items ) {

			$key = array_search($items['id'], $uids); 
	
			foreach( $items['data'] as $item ) {

				$nucleo['policys'][] = [
					'politica_id' => intval($uids[$key]),
					'titulo' => $item['title'],
					'preco'  =>  floatval($item['value'])
				];

			}

		}
		
		Session::put('nucleo', $nucleo);

		return Response::json([
			'redirect' => url("/frete")
		], 200);

		
	}


	// adiciona frete ao carrinho de compra
	public function addFreteToCart(Request $request)
	{

		$this->validate($request, [
			'prazo' => 'required',
			'valor' => 'required',
			'cep' => 'required',
			'endereco_id' => 'required',
			'metodo_frete' => 'required'
		]);

		// valida forma correta de valor
		if( $request->input("valor") == 0){
			$valor = 0.00;
		}else{
			$valor = $request->input("valor");
		}

		$frete = [
			'metodo_frete' =>  $request->input("metodo_frete"),
			'prazo' => $request->input("prazo"),
			'valor' => $valor,
			'cep' => $request->input("cep"),
			'endereco_id' => $request->input("endereco_id")
		];

		$request->session()->get("cart")->frete = $frete;
		$cart = $request->session()->get("cart");
		$utils = json_decode(json_encode($request->session()->get("utils"), false));

		// verifica se o pedido é grátis
		if($cart->precoTotal == 0){
			return view("Beta::loggedin.finaliza-compra-gratis", compact("cart","utils"));
		}		

		return view("Beta::loggedin.finaliza-compra", compact("cart","utils"));

	}

	

	/* adiciona frete e dados de pagamento ao carrinho de compra
	*	Este método é somente para compras que usam o tipo DIGTAL
	*	este método é pois o TIPO DIGITAL parte do processo de compra
	*/
	public function addFreteAndPaymentDataToCart(Request $request)
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
		$utils = json_decode(json_encode($request->session()->get("utils")), TRUE);

		return view("Loja::loggedin.finaliza-compra", compact("cart","utils"));		
	}

	public function payment( Request $req ) 
	{

		$data = $req->input('data');
		
		$cart   = Session::get('cart');
		$nucleo = Session::get('nucleo');
		
		extract($nucleo);
		extract($data);
		
		$referencia = $cart->cliente->id.date('dmy').rand(1000, 9999);
		
		$spag = new SPag([

			'referencia'    => $referencia, // indentificacao do produto
			'token'         => $token,
			'quantity'      => $quantity,
			'value'         => $value,
			'interest_free' => $event['interest_free'],
			'desconto'      => isset($event['valor_do_desconto']) ? $event['valor_do_desconto'] : 0,

			'info' => $info,

			'credit' => [
				'status' => 1,
				'card'   => $card
			],

			'debito' => ['status'=>0],
			'boleto' => ['status'=>0],

			'address' => [
				'billing' => 1,
				'data'    => $address
			],

			'items' => [
				'images'      => $imagens,
				'adicionais'  => $policys,
				'photo_value' => $event['valor_da_foto'],
				'gallery'     => $event['gallery']
			]

		]);

		if( !empty($spag->is_success) ) {

			$data = json_decode($spag->is_success, true);

			$this->buildOrder($data, $nucleo);

			$this->saveCartSession(' ');

			$this->saveCupom( $cart, $nucleo['uids']['cupom_id'] );

			Session::forget('cart'); // deleta carts da session
			Session::forget('utils'); // deleta utils da session
			Session::forget('scart'); // deleta scart da session

			return Response::json([
				'status' => 1, 
				'data' => $data
			], 200);
		}

		return Response::json([
			'status'=>0, 
			'message'=>$spag->error
		], 422);

	}

	// public function buildPayment(Request $request)
	// {
	// 	$cart = $request->session()->get("cart");

	// 	$this->validate( $request,
	// 		[
	// 			'name' => 'required',
	// 			'last_name' => 'required',
	// 			'email' => 'required|email',
	// 			'data_nascimento' => 'required',
	// 			'celular' => 'required',
	// 			'cpf' => 'required',
	// 			'card_name' => 'required'
	// 		],
	// 		[
	// 			'name.required' => 'O campo Nome é obrigatório!',
	// 			'last_name.required' => 'O campo Sobrenome é obrigatório!',
	// 			'email.required' => 'O campo Email é obrigatório!',
	// 			'email.email' => 'Digite um Email válido!',
	// 			'data_nascimento.required' => 'O campo Data de Nascimento é obrigatório!',
	// 			'celular.required' => 'O campo Celular é obrigatório!',
	// 			'cpf.required' => 'O campo CPF é obrigatório!',
	// 			'card_name.required' => 'O Nome Impresso no Cartão é obrigatório'
	// 		]
	// 	);

	// 	$utils = json_decode(json_encode($request->session()->get("utils")), true);
		
	// 	$desconto = ( -1 * (str_replace( ',', '.', $cart->valDesconto) ) );

	// 	// cria arrays para sistema usar posteriormente
	// 	$itens = $endereco = [];
	// 	$contador = 0;

	// 	// insere imagens dentro de itens
	// 	for($i = 0; $i < count($cart->imagens); $i++){			

	// 		$itens[$i] = [
	// 			'itemId' => $cart->imagens[$i]['id'],
	// 			'itemDescription' => 'Foto',
	// 			'itemAmount' => str_replace( ',', '.', $cart->precoUnidadeImagem),
	// 			'itemQuantity' => '1',

	// 		];
	// 	}

	// 	$contador = 0;

	// 	// contador de politicas
	// 	$contador = count($itens);

	// 	// insere politicas dentro de itens
	// 	for($j = 0; $j < count($cart->politicas); $j++){
			
	// 		if( $cart->politicas[$j]['preco'] > 0.00){
	// 			$itens[$contador] = [
	// 				'itemId' => $cart->politicas[$j]['politica_id'],
	// 				'itemDescription' => $cart->politicas[$j]['titulo'],
	// 				'itemAmount' => str_replace( ',', '.', $cart->politicas[$j]['preco'] ),
	// 				'itemQuantity' => '1'
	// 			];
	// 			$contador++;
	// 		}
	// 	}

	// 	// recupera endereço do cliente
	// 	$enderecoCli = DB::table('enderecos')->find($cart->frete['endereco_id']);
		
	// 	// verifica se endereço da instituição realmente existe no banco de dados
	// 	if( count($enderecoCli) > 0){
	// 		// seta dados de endereço da instituição para o pag seguro
	// 		$endereco['shippingAddressStreet'] = $enderecoCli->logradouro;
	// 		$endereco['shippingAddressNumber'] =  $enderecoCli->numero;
	// 		$endereco['shippingAddressDistrict'] = $enderecoCli->bairro;
	// 		$endereco['shippingAddressPostalCode'] = $enderecoCli->cep;
	// 		$endereco['shippingAddressCity'] = $enderecoCli->cidade;
	// 		$endereco['shippingAddressState'] = $enderecoCli->estado;
	// 	} else{
	// 		return back()->withErrors(['error', 'O endereço está incorreto, por favor corrija e tente novamente.']);
	// 	}


	// 	// insere endereço escolhido pelo cliente
	// 	// for($i = 0; $i < count($cart->cliente->enderecos); $i++){
			
	// 	// 	// procura endereço nos endereços cadastrados pelo cliente
	// 	// 	if( $cart->frete['endereco_id'] == $cart->cliente->enderecos[$i]->id){

	// 	// 		$endereco['shippingAddressStreet'] = $cart->cliente->enderecos[$i]->logradouro;
	// 	// 		$endereco['shippingAddressNumber'] = $cart->cliente->enderecos[$i]->numero;
	// 	// 		$endereco['shippingAddressDistrict'] = $cart->cliente->enderecos[$i]->bairro;
	// 	// 		$endereco['shippingAddressPostalCode'] = $cart->cliente->enderecos[$i]->cep;
	// 	// 		$endereco['shippingAddressCity'] = $cart->cliente->enderecos[$i]->cidade;
	// 	// 		$endereco['shippingAddressState'] = 'SP';
				
	// 	// 	}else{ // caso não encontre o endereço escolhido na lista de cliente
				
	// 	// 		// recupera dados de endereço da instituição(estilo de retirada na escola)
	// 	// 		$enderecoInstituicao = DB::table('enderecos')->find($cart->frete['endereco_id']);				
				
	// 	// 		// verifica se endereço da instituição realmente existe no banco de dados
	// 	// 		if( count($enderecoInstituicao) > 0){
	// 	// 			// seta dados de endereço da instituição para o pag seguro
	// 	// 			$endereco['shippingAddressStreet'] = $enderecoInstituicao->logradouro;
	// 	// 			$endereco['shippingAddressNumber'] =  $enderecoInstituicao->numero;
	// 	// 			$endereco['shippingAddressDistrict'] = $enderecoInstituicao->bairro;
	// 	// 			$endereco['shippingAddressPostalCode'] = $enderecoInstituicao->cep;
	// 	// 			$endereco['shippingAddressCity'] = $enderecoInstituicao->cidade;
	// 	// 			$endereco['shippingAddressState'] = $enderecoInstituicao->estado;
	// 	// 		}
	// 	// 	}

	// 	// }

	// 	$idPedido = $cart->cliente->id.date('dmy').rand(1000, 9999);

		
	// 	try {

 //    		//chamar os métodos da bilbioteca aqui dentro
			
	// 		$installmentValue = str_replace( ',', '.', $request->input('valor_parcela')) == 0.00
	// 			? str_replace( ',', '.', $request->input('valorTotal'))
	// 			: str_replace( ',', '.', $request->input('valor_parcela'));

	// 		$telefone = (strlen(trim($cart->cliente->telefone)) < 10 ) ? $cart->cliente->telefone : $request->input("celular");

	// 		$pagseguro = PagSeguro::setReference($idPedido)
	// 			->setSenderInfo([
	// 				'senderName'  =>  $request->input('name') .' '.  $request->input('last_name'), //Deve conter nome e sobrenome
	// 				'senderPhone' => $request->input("celular"), //Código de área enviado junto com o telefone
	// 				'senderEmail' =>  $request->input('email'),
	// 				'senderHash'  => $request->input('senderHash'),
	// 				'senderCPF'   =>  $request->input('cpf') //Ou CNPJ se for Pessoa Júridica
	// 			])
	// 			->setCreditCardHolder([
	// 				'creditCardHolderName'      => $request->input('card_name'), // $cart->cliente->name .' '. $cart->cliente->last_name, //Deve conter nome e sobrenome
	// 				'creditCardHolderPhone'     => $request->input("celular"), //Código de área enviado junto com o telefone
	// 				'creditCardHolderCPF'       => $request->input('cpf'), //Ou CNPJ se for Pessoa Júridica
	// 				'creditCardHolderBirthDate' => $request->input('data_nascimento')
	// 			])
	// 			->setShippingAddress($endereco)
	// 			->setBillingAddress($endereco)
	// 			->setItems(
	// 				$itens
	// 			)
	// 			->setShippingInfo([
	// 				'shippingType' => '1', //: 1 – PAC, 2 – SEDEX, 3 - Desconhecido
	// 				'shippingCost' => str_replace( ',', '.', $cart->frete['valor'] )
	// 			])
	// 			->setExtraAmount( $desconto )
	// 			->send([
	// 				'paymentMethod' => 'creditCard',
	// 				'creditCardToken' => $request->input('token'),
	// 				'installmentQuantity' => ( $request->input('parcelas') > 0 ) ? $request->input('parcelas') : 1,
	// 				'installmentValue' => $installmentValue,
	// 				'noInterestInstallmentQuantity' => intval($utils['parcelas_sem_juros'])
	// 			]);
	// 	}
	// 	catch(\Artistas\PagSeguro\PagSeguroException $e) {
			
	// 		$error =[ 
	// 			'error' => [
	// 				'code' => $e->getCode(), 
	// 				'message' => $e->getMessage()
	// 			]
	// 		];

	// 		return json_encode($error,false);
	// 	}

	// 	$paymentData = json_encode($pagseguro);
	// 	// $retornoPagSeguro = json_decode($paymentData, false)

	// 	// invoca construtor de pedidos
	// 	$this->buildOrder($idPedido, json_decode($paymentData, false), $request, $itens);

	// 	$this->saveCartSession(' ');

	// 	$this->saveCupom( $cart );

	// 	// deleta carts da session
	// 	$request->session()->forget('cart');

	// 	// deleta utils da session
	// 	$request->session()->forget('utils');

	// 	// deleta scart da session
	// 	$request->session()->forget('scart');


	// 	// retorna todos os dados da compra
	// 	return $paymentData;
	// }


	/*
	*	constroi o pedido
	*	recebe os dados do método de pagamento
	*/

	protected function buildOrder($data, $nucleo)
	{
		
		$name_modulo = str_replace('-', '_', str_slug($nucleo['event']['metodo_frete']));
		$modulo = DB::table('admin_modulo_'. $name_modulo)->first();

		$cart = Session::get("cart");

		$result = Pedido::create(
			[
				'cliente_id'     => $cart->cliente->id,
				'endereco_id'    => $nucleo['uids']['endereco_id'],
				'valor_frete'    => $modulo->preco,
				'prazo_entrega'  => $modulo->prazo_entrega,
				'num_pedido'     => $data['reference'],
				'code_transacao' => $data['code'],
				'referencia'     => $data['reference'],
				'tipo_pagamento' => intval($data['type']),
				'total_parcial'  => floatval($data['netAmount']),
				'desconto'       => floatval($nucleo['event']['discount']),
				'valor_pedido'   => floatval($data['grossAmount']),
				'metodo_frete'   => $nucleo['event']['metodo_frete'],
				'status'         => $data['status']
			]
		);

		$list   = [];

		foreach( ['imagens', 'policys'] as $i ) {

			foreach( $nucleo[$i] as $item ) {

				$list['pedido_id']  = $result->id;
				$list['produto_id'] = $nucleo['uids']['product_id'];

				if( $i == 'imagens' ) {
					
					$list['item_id'] = $item['id'];
					$list['quantidade'] = 1;
					$list['valor_unitario'] = $nucleo['event']['valor_da_foto'];
					$list['descricao'] = '';
					$list['titulo'] = 'Foto / '. $nucleo['event']['gallery'];

				}

				elseif( $i == 'policys' ) {
					
					$list['item_id'] = $item['politica_id'];
					$list['quantidade'] = 1;
					$list['valor_unitario'] = $item['preco'];
					$list['descricao'] = '';
					$list['titulo'] = $item['titulo'];

				}

				ItensPedido::create($list);

			}

		}
	
		// insere todos os retornos do pagseguro para validação posterior
		DB::table('transaction_pagseguro')->insert([
			'pedido_id' => $result->id, 
			'pedido_code' => $data['reference'],
			'json' => json_encode($data)
		]);

		$this->abandonedCartClear( $cart->cliente->id );

		// recupera dados para disparar emails de confirmação de compra
		// e nova ordem de compra
		$pedidos = $this->getOrderDataTo( $result->id );

		// $this->sendClientNewOrderEmail($pedidos);
		// $this->sendAdminNewOrderEmail($pedidos);

		return true;

	}

	// protected function buildOrder($referencia, $payment, $request, $itens = 0)
	// {

	// 	$cart = $request->session()->get("cart");
	// 	$utils = json_decode(json_encode($request->session()->get("utils")), TRUE);		

	// 	$pedido = Pedido::create([
	// 		'num_pedido'     => $referencia,
	// 		'endereco_id'    => $cart->frete['endereco_id'],
	// 		'code_transacao' => $payment->code,
	// 		'valor_frete'	 => $cart->frete['valor'],
	// 		'prazo_entrega'  => $cart->frete['prazo'],
	// 		'metodo_frete'   => $cart->frete['metodo_frete'],
	// 		'referencia'     => $payment->reference,
	// 		'cliente_id'     => $cart->cliente->id,
	// 		'valor_pedido'   => $payment->grossAmount,
	// 		'status'         => $payment->status,
	// 		'total_parcial'  => $payment->netAmount,
	// 		'desconto'       => empty($cart->valDesconto) ? 0.00 : $cart->valDesconto,
	// 		'tipo_pagamento' => $payment->type
	// 	]);


	// 	for($i = 0; $i < count($cart->imagens);$i++){
	// 		$item = [
	// 			'pedido_id' => $pedido->id,
	// 			'produto_id' => $utils['produto_id'],
	// 			'item_id' => $cart->imagens[$i]['id'],
	// 			'quantidade' => 1,
	// 			'valor_unitario' => $cart->precoUnidadeImagem,
	// 			'descricao' => $cart->imagens[$i]['mensagem'],
	// 			'titulo' => 'Foto'
	// 		];
	// 		ItensPedido::create($item);
	// 	}

	// 	for($i = 0; $i < count($cart->politicas);$i++){
	// 		$item = [
	// 			'pedido_id' => $pedido->id,
	// 			'produto_id' => $utils['produto_id'],
	// 			'item_id' => $cart->politicas[$i]['politica_id'],
	// 			'quantidade' => 1,
	// 			'valor_unitario' =>$cart->politicas[$i]['preco'],
	// 			'descricao' => 'politica',
	// 			'titulo' => 'Opcionais: '. $cart->politicas[$i]['titulo']
	// 		];
	// 		ItensPedido::create($item);
	// 	}

	// 	// insere todos os retornos do pagseguro para validação posterior
	// 	DB::table('transaction_pagseguro')->insert([
	// 		'pedido_id' => $pedido->id, 
	// 		'pedido_code' => $numPedido,
	// 		'json' => json_encode($payment)
	// 	]);

	// 	$this->abandonedCartClear( $cart->cliente->id );

	// 	// recupera dados para disparar emails de confirmação de compra
	// 	// e nova ordem de compra
	// 	$pedidos = $this->getOrderDataTo( $pedido->id );
	// 	$this->sendClientNewOrderEmail($pedidos);
	// 	$this->sendAdminNewOrderEmail($pedidos);

	// 	return true;

	// }


	public function buildFreePayment(Request $request)
	{
		$cart = $request->session()->get("cart");
		$utils = json_decode(json_encode($request->session()->get("utils")), TRUE);	
		$idPedido = $cart->cliente->id . date('dmy') . rand(1000, 9999);

		$payment = [			
			'code' => $idPedido.'0000',
			'reference' => $idPedido,
			'netAmount' => 0.00,
			'status' => 3,
			'type' => 0,
			'grossAmount' => $cart->valDesconto,
		];

		$payment =  json_decode(json_encode( $payment ), false);
		
		$this->buildOrder( $idPedido, $payment, $request, 0 );

		$this->abandonedCartClear( $cart->cliente->id );

		$this->saveCupom( $cart );
		
		// deleta carts da session
		$request->session()->forget('cart');
		
		// deleta utils da session
		$request->session()->forget('utils');

		return json_encode( $payment );
	}


	public function getOrderDataTo($id)
	{
		$pedidos = DB::table('pedidos as p')
					->where('p.id', $id)
					->leftJoin('itens_pedidos as ip', 'ip.pedido_id', '=', 'p.id')
					->leftJoin('enderecos as end', 'end.id', '=', 'p.endereco_id')
					->leftJoin('produtos as prod', 'prod.id', '=', 'ip.produto_id')
					->leftJoin('events', 'events.id', '=', 'prod.event_id')
					->leftJoin('clientes as cli','cli.id','=','p.cliente_id')
					->leftJoin('fotos_produto as fotos', 'fotos.id', '=', 'ip.item_id')
					->select(						
						'prod.nome as prod_nome',
						'events.name as event_name', 
						'end.*', 
						'ip.*', 
						'p.*',
						'cli.name as nome_cliente',
						'cli.last_name as sobrenome_cliente',
						'cli.email as email',
						'fotos.name as src'
					)->get();

		return $pedidos;
	}

	public function saveCupom( $cart, $cupom_id ) 
	{
		
		if( !empty($cupom_id) ) {
			\App\Models\CouponsUsed::create(['id_cliente'=>$cart->cliente['id'], 'id_cupom'=>$cupom_id]);
		}

	}

	public function sendClientNewOrderEmail($pedidos)
	{		
		// $to = 'atendimento@multiply.art.br';
		// $to = 'neferson.oliveira@wa5.com.br';
		$to = $pedidos[0]->email;
		$email = new EmailHelper();
		$email->confirmaCompraCliente( $to, $pedidos );
		return $pedidos;
	}


	public function sendAdminNewOrderEmail($pedidos)
	{
		$to = 'foto@multiply.art.br';
		// $to = 'neferson.oliveira@wa5.com.br';
		$email = new EmailHelper();
		$email->setAdminNewOrderEmail( $to, $pedidos );
		return $pedidos;
	}


	public function killSessionCart(Request $request)
	{
		$request->session()->forget("cart");

		$client = Auth::guard('cliente')->user();

		$cart = DB::table('carrinho_abandonado')
		->where([
			['cliente_id', '=', $client->id ],
			['status', '=', 1]
		])->update(
			[
				'status' => 0,
				'session_id' => $request->session()->get('session_id')
			]
		);

		return json_encode(array('success' => true));
	}


	public function recuperaCarrinho( Request $request )
	{
		$client = Auth::guard('cliente')->user();		
		$cart = DB::table('carrinho_abandonado')
		->where([
			['cliente_id', '=', $client->id ]
		])->orderBy('id', 'desc')->first();	

		$request->session()->put('cart', json_decode($cart->session, false));
		$request->session()->put('utils', json_decode($cart->utils, true));

		// dd( json_decode($cart->utils, true) );

		$cart  = json_decode($cart->session, false);
		
		// dd( $request->session()->get('cart') );
		
		// recupera url das imagens para passar para a view
		for($i = 0; $i < count($cart->imagens); $i++){
			$clean[$i] = DB::table('fotos_produto')->where('id', '=', $cart->imagens[$i]->id )->select('url')->first();
			$cart->imagens[$i]->url = $clean[$i]->url;
		}
		// transforma retorno em objeto
		$galeria = json_decode( json_encode($cart->imagens, false) );
		return view("Loja::loggedin.galeria-confirm", compact('galeria'));
	}

	public function abandonedCartClear( $user_id )
	{
		AbandonedCart::where('cliente_id', $user_id)->update([
			'session' => null
		]);
	}

}
