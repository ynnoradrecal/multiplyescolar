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
use App\Models\Cliente;
use App\Models\ItensPedido;
use App\Models\AbandonedCart;
use App\Models\RelContsEnd;
use App\Models\Endereco;

// Helpers
use Carbon\Carbon;

class ArquivosDigitaisController extends Controller
{
	public function index(Request $request)
	{
		
		$user = Auth::guard('cliente')->user();
		$utils = json_decode(json_encode($request->session()->get("utils")), TRUE);

		$cart = $request->session()->get("cart");

		$endereco = DB::table('rel_conts_ends as rce')
						->where('id_conta', $user->id)
							->leftJoin('enderecos as end', 'end.id', '=', 'rce.id_endereco')
								->get();
		$cart->cliente = $user;
		$cart->cliente->enderecos = (count($endereco) != 0) ? $endereco : '';

		$evento = DB::table('events')
					->where('id', $utils['evento_id'])
					->first();
		

		$utils['titulos'][0]['event_name'] = $evento->name;
		
		$utils = json_decode(json_encode($utils), false);

		// dd( $utils );

		$request->session()->put('utils', $utils);

		$cart->frete['valor'] = 0.00;

		return view('Loja::loggedin.digital-client-data', compact('cart','utils'));
		
	}

	public function saveCLientData(Request $request)
	{
		//dd($request->all());
		
		$auth = Auth::guard('cliente')->user();
		$cart = $request->session()->get("cart");

		$this->validate($request, [
			'name' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'data_nascimento' => 'required',
			'telefone' => 'required',
			'celular' => 'required',
			'cpf' => 'required'
		]);

		// update user data
		DB::table('clientes')
			->where('id', $auth->id)
			->update([
				'data_nascimento' => $request->input("data_nascimento"),
				'telefone' => $request->input("telefone"),
				'celular' => $request->input("celular"),
				'cpf' => $request->input("cpf")
			]);

		// get all the user data
		$user = DB::table('clientes')
			->where('id', $auth->id)
			->first();
		
		// set user into cart object
		$cart->cliente = $user;

		if($request->input('logradouro') !== null){
			// cadastra endereço
			$endereco = Endereco::create([
				'cep' => $request->input('cep'),
				'logradouro' => $request->input('logradouro'),
				'numero' => $request->input('numero'),
				'bairro' => $request->input('bairro'),
				'cidade' => $request->input('cidade'),
				'estado' => $request->input('estado')
			]);

			RelContsEnd::create([
				'id_conta' =>  $auth->id,
				'tipo_de_conta' => 'cliente',
				'id_endereco' => $endereco->id
			]);
		}else{
			$endereco = Endereco::where('id', $request->input("id_endereco"))->first();
		}

		$request->session()->get("cart")->endereco = $endereco;		

		$enderecos = DB::table('rel_conts_ends')
		->where([
			['rel_conts_ends.id_conta', '=',$auth->id],
			['rel_conts_ends.tipo_de_conta', '=', 'cliente']
		])
		->leftJoin('enderecos as end', 'end.id', '=', 'rel_conts_ends.id_endereco')
		->select('end.*')
		->get();

		$cart->cliente->enderecos = $enderecos;

		$frete = [
			'metodo_frete' => 'Download de Arquivo',
			'prazo' => 1,
			'valor' => 0.00,
			'cep' => $request->input("cep"),
			'endereco_id' => $endereco->id
		];

		$request->session()->get("cart")->frete = $frete;
		
		$utils = json_decode(json_encode($request->session()->get("utils"), false));

		return view("Loja::loggedin.finaliza-compra", compact("cart","utils"));
	}
}