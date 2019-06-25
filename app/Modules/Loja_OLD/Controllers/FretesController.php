<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Correios;
use URL;
use Auth;
use App\Models\Cart;
use App\Models\Endereco;
use App\Models\AbandonedCart;
use Carbon\Carbon;

class FretesController extends Controller
{
	
	public function index( Request $request )
	{
		//dd($request);

		$metodos = DB::table('admin_modulos')->where([
			['tipo', '=', 'frete'],
			['status', '=', 1]
		])->get();

		
		// recupera instancia de carrinho, caso exista
		$cart = Session::has('cart') ? Session::get('cart') : null;

		
		
		 
		$utils = Session::has('utils') ? Session::get('utils') : null;

		
		// recupera titulos dos produtos, politicas e eventos em carrinho, caso esses dados existam em session
		if( count($utils) > 0 ){
			$utils = DB::table('produtos')
				->where('produtos.id', '=', $utils['produto_id'])
				->leftJoin('alunos', 'produtos.aluno_id', '=', 'alunos.id')
				->join('events', 'produtos.event_id', '=', 'events.id')
				->select('produtos.nome AS prod_name', 'events.name AS event_name', 'alunos.nome AS aluno_name')
				->get();
		}


		// recupera lista de endereços do cliente
		$enderecos = DB::table('rel_conts_ends')
			->where([
				['rel_conts_ends.id_conta', '=', $cart->cliente->id],
				['rel_conts_ends.tipo_de_conta', '=', 'cliente']
			])
			->join('enderecos', 'rel_conts_ends.id_endereco', '=', 'enderecos.id')
			->select('enderecos.*')
			->get();


		for($i = 0; $i < count($metodos); $i++ ){
			$metodos[$i]->config = $this->getConfigs($metodos[$i]->slug);
		}

		$request->session()->push("utils.titulos", $utils[0]);

		
		return view("Loja::loggedin.frete", compact("metodos", "cart", "utils"));
	}


	public function confirma( )
	{
		$cart = Session::has('cart') ? Session::get('cart') : null;

		dd( $cart );
	}


	protected function getConfigs( $slug )
	{
		$configs = DB::table('admin_modulo_'.$slug)->find(1);
		return $configs;
	}


	public function addEndereco(Request $request)
	{
		
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

		$metodos = DB::table('admin_modulos')->where([
			['tipo', '=', 'frete'],
			['status', '=', 1]
		])->get();

		// recupera instancia de carrinho, caso exista
		$cart = Session::has('cart') ? Session::get('cart') : null;

		$cart->cliente->enderecos = [ 0 => $endereco ];

		$utils = Session::has('utils') ? Session::get('utils') : null;

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


		return view("Loja::loggedin.frete", compact("metodos", "cart", "utils"));

		// return redirect('minha-conta/'. $request->input('user_id') .'/enderecos');
	}

}