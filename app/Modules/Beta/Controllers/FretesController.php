<?php

namespace App\Modules\Beta\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Endereco;
use App\Models\AbandonedCart;

use Carbon\Carbon;

use Session;
use DB;
use Correios;
use URL;
use Auth;
use Response;

class FretesController extends Controller
{
	
	public function index( Request $request )
	{
		
		$delivery = []; $address = [];

		$cart   = Session::has('cart') ? Session::get('cart') : null;
		$nucleo = Session::get('nucleo');

		$uids  = (object) $nucleo['uids'];
		$event = (object) $nucleo['event'];

		$product = \App\Models\Produtos::where('id', $uids->product_id)->first();

		$nucleo['event']['valor_da_foto'] = floatval($product->foto_unit_val);

		if( $product->instituicao_id == 0 ) {

			$modulo = DB::table('rel_servico_entrega')->where('produto_id', $uids->product_id)
			->leftJoin('admin_modulos', 'rel_servico_entrega.modulo_id', '=', 'admin_modulos.id')
			->first();
			
			$alladdress = DB::table('rel_conts_ends')->where('id_conta', $cart->cliente->id)
			->leftJoin('enderecos', 'rel_conts_ends.id_endereco', '=', 'enderecos.id')
			->select('enderecos.*')->get();

			foreach( $alladdress as $i => $item ) {
				if( $item->entrega == 1 ) {
					$address = $alladdress[$i];
				}
			}

			$delivery = $this->filterSettingModule( $modulo->nome, $modulo->slug, $product->descricao, $address );

		}

		else {

			$alladdress = [];

			$delivery = [
				'servico'    => 'Retirar na Instituicão',
				'endereco'   => $this->getAddressIntituicao($product->instituicao_id),
				'observacao' => $product->descricao
			];

		}

		$info = $this->getInfoPedido($event, $cart, $product);

		Session::put('nucleo', $nucleo);

		return view("Beta::loggedin.frete", compact('event', 'delivery', 'info', 'uids', 'alladdress'));
		
	}

	public function getInfoPedido($event, $cart, $product)
	{

		$nucleo = Session::get('nucleo');
		$scart  = Session::get('scart');

		$policys = $nucleo['policys'];

		$info = [
			[
				'descricao' => 'Fotos / '. $event->gallery,
				'quantidade' => count($scart['imagens']),
				'valor_da_unidade' => $product->foto_unit_val,
				'subtotal' => floatval($product->foto_unit_val) * count($scart['imagens'])
			]
		];
		
		foreach( $policys as $item ) {
			$info[] = [
				'descricao' => $item['titulo'],
				'quantidade' => 1,
				'valor_da_unidade' => floatval($item['preco']),
				'subtotal' => floatval($item['preco'])
			];
		}

		return $info;

	}

	public function filterSettingModule( $titulo, $slug, $descricao, $address ) 
	{

		$item = DB::table('admin_modulo_'. $slug)->first();

		switch( $slug ) {

			case 'envio_digital':

				return [
					'servico' => $titulo,
					'endereco' => 'Mídia digital não tem endereço!',
					'observacao' => $descricao
				];

			break;

			default: 

				return [

					'servico' => $titulo,

					'endereco' => implode('', [
						$address->logradouro .' - ',	
						$address->bairro .'<br />',
						$address->cidade .' ',
						$address->estado .' - ', 
						$address->numero
					]),

					'observacao' => $descricao

				];

		}

	}

	public function getAddressIntituicao( $id )
	{
		$instituicao = \App\Models\Instituicao::where('id', $id)->first();
			
		$address =  DB::table('rel_conts_ends')->where('id_conta', $instituicao->id)
		->leftJoin('enderecos', 'rel_conts_ends.id_endereco', '=', 'enderecos.id')->first();	

		return implode('', [
			$address->logradouro .' - ',	
			$address->bairro .'<br />',
			$address->cidade .' ',
			$address->estado .' - ', 
			$address->numero
		]);

	}

	protected function getConfigs( $slug )
	{
		$configs = DB::table('admin_modulo_'.$slug)->find(1);
		return $configs;
	}


	public function addEndereco(Request $request)
	{

		$utils = Session::has('utils') ? Session::get('utils') : null;
		
		$validate = $this->validate($request, [
			'logradouro' => 'required|min:2',
			'cep'	=> 'required|min:8',
			'numero' => 'required|min:1',
			'bairro' => 'required|min:2',
			'estado' => 'required|min:2',
			'cidade' => 'required|min:2'
		]);

		$complemento = '';

		if( null !== $request->input('complemento') ){
			$complemento = $request->input('complemento');
		}

		$endereco = Endereco::create([
			'logradouro' =>  $request->input('logradouro'),
			'cep' =>  $request->input('cep'),
			'numero' 	=>  $request->input('numero'),
			'bairro' 	=>  $request->input('bairro'),
			'estado' 	=>  $request->input('estado'),
			'cidade' 	=>  $request->input('cidade'),
			'entrega' 	=>  1
		]);

		$relacionamento = [
			'id_conta' => $request->input('user_id'),
			'tipo_de_conta' => 'cliente',
			'id_endereco' => $endereco->id
		];

		DB::table('rel_conts_ends')->insert($relacionamento);

		$metodos = [];
		
		$metodosModel = DB::table('rel_servico_entrega as rse')->where([
						['produto_id', '=',  $utils['produto_id']]
					])
					->leftJoin('admin_modulos as admm', 'admm.id', '=', 'rse.modulo_id')
					->get();
		
		//dd( $metodosModel );

		for($i = 0; $i < count($metodosModel); $i++){
			$metodos[$i] = DB::table('admin_modulo_'.$metodosModel[$i]->slug)->first();
			$metodos[$i]->nome = $metodosModel[$i]->nome;
			$metodos[$i]->slug = $metodosModel[$i]->slug; 
		}

		// recupera instancia de carrinho, caso exista
		$cart = Session::has('cart') ? Session::get('cart') : null;

		$cart->cliente->enderecos = [ 0 => $endereco ];		

		// dd($utils);

		// recupera titulos dos produtos, porliticas e evento em carrinho, casa esses dados existam em session
		if( count($utils) > 0 ){
			$utils = DB::table('produtos')
				->where('produtos.id', '=', $utils['produto_id'])
				->leftJoin('alunos', 'produtos.aluno_id', '=', 'alunos.id')
				->join('events', 'produtos.event_id', '=', 'events.id')
				->select('produtos.nome AS prod_name', 'events.name AS event_name', 'alunos.nome AS aluno_name')
				->get();
		}


		for($i = 0; $i < count($metodos); $i++ ){
			$metodos[$i]->config = $this->getConfigs($metodos[$i]->slug);
		}


		return view("Beta::loggedin.frete", compact("metodos", "cart", "utils"));

		// return redirect('minha-conta/'. $request->input('user_id') .'/enderecos');
	}

	public function coupon( Request $req ) 
	{
		
		if(empty($req->input('cupom')))
			return Response::json(['Necessário digitar codigo do cupom!'], 422);

		$code = strtoupper($req->input('cupom'));

		$cupom = \App\Models\DiscountCupon::where('code', $code)->first();
		
		if( count($cupom) == 0 ) {
			return Response::json(['Codigo de cupom não localizado'], 422);
		}

		$exists = Session::has('cart');

		if( $exists ) {

			$cart   = Session::get('cart');
			$scart  = Session::get('scart');
			$nucleo = Session::get('nucleo');
			
			if( $this->limit_for_use($cart->cliente->id, $cupom->id, $cupom->limit_for_use) )
				return Response::json(['Esse cupom ja foi utilizado por esse usuário!'], 422);

			$event = (object) $nucleo['event'];

			// tipo de cupom
			if( $cupom->type == 'fotos' ) {
				$nucleo['event']['valor_do_desconto'] = $event->valor_da_foto * floatval($cupom->value);
			}

			elseif($cupom->type == 'fixo'){
				$nucleo['event']['valor_do_desconto'] = floatval($cupom->value);
			}
			
			$nucleo['event']['total'] = $event->valor_da_foto * count($nucleo['imagens']);
			$nucleo['event']['id_cupom'] = $cupom['id'];
			
			Session::put([
				'cart' => $cart
			]);

			if( ($nucleo['event']['total'] - $nucleo['event']['valor_do_desconto']) <= 0 ) {
				$total = 0.00;
			}

			else{
				$total = ($nucleo['event']['total'] - $nucleo['event']['valor_do_desconto']);
			}

			return Response::json([
				'discount' => $nucleo['event']['valor_do_desconto'],
				// 'total'    => $total,
			], 200);

		}

	}

	public function limit_for_use( $id_cliente, $id_cupom, $limit )
	{

		$coupons = \App\Models\CouponsUsed::where('id_cliente', $id_cliente)
			->where('id_cupom', $id_cupom)->get()->toArray();

		if(count($coupons) == (int) $limit) {
			return true;
		}

	}

	public function newAddress( Request $req ) 
	{

		$cart = Session::get('cart');

		$fill = $req->input('fill');
		
		$fill['cidade'] = $fill['localidade']; $fill['estado'] = $fill['uf'];

		foreach (['uf', 'localidade'] as $key)
			unset($fill[$key]);

		$fill['status'] = 1;	

		if( $fill['entrega'] == 1 ) {
			$this->altStatusEntrega( $cart->cliente->id );
		}
		
		try {

			$id = \App\Models\Endereco::create($fill)->id;

			\App\Models\RelContsEnd::create(['id_conta' => $cart->cliente->id, 
				'tipo_de_conta' => 'cliente',
			'id_endereco' => $id]);

			return Response::json([
				'id'=>$id, 
				'message'=>'Endereço salvo com sucesso!'
			], 200);

		} catch (\Exception $e) {
			return $e->getMessage();
		}

		
	}

	public function altStatusEntrega( $id ) 
	{

		$uids = [];

		$all_address = DB::table('rel_conts_ends')->where('id_conta', $id)
		->leftJoin('enderecos', 'rel_conts_ends.id_endereco', '=', 'enderecos.id')
		->select('enderecos.*')->get();	

		foreach( $all_address as $address )
			$uids[] = $address->id;


		try {
			
			return \App\Models\Endereco::whereIn('id', $uids)->update(['entrega'=>0]);

		} catch (Exception $e) {
			return $e->getMessage();
		}


	}

	public function changeAddressDelivery( Request $req ) 
	{

		$uid = $req->input('id');
		$uids = $req->input('uids');

		try {
			
			\App\Models\Endereco::whereIn('id', $uids)->update(['entrega'=>0]);
			\App\Models\Endereco::where('id', $uid)->update(['entrega'=>1]);

			return Response::json([
				'message'=>'Endereço entrega alterado com sucesso!'
			], 200);

		} catch (\Exception $e) {
			return $e->getMessage();
		}

	}

	public function finalizePayment( Request $req ) 
	{

		$nucleo = Session::get('nucleo');

		foreach( ['total', 'discount'] as $key ) {
			$nucleo['event'][$key] = floatval($req->input($key));
		}

		$all = \App\Models\Endereco::where('id', $req->input('id_address'))->first();

		$nucleo['address'] = [
			"logradouro" => $all->logradouro,
		    "cep" => $all->cep,
		    "complemento" => $all->complemento,
		    "numero" => $all->numero,
		    "bairro" => $all->bairro,
		    "estado" => $all->estado,
		    "cidade" => $all->cidade,
		];
		
		Session::put('nucleo', $nucleo);

		return Response::json([
			'redirect' => url('/beta/checkout')
		], 200);

	}

}