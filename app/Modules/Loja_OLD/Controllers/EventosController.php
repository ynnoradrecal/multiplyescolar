<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use DB;
use Validator;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventosController extends Controller
{
	protected $evento;

	public function __construct()
	{
		$this->evento = Event::get();
	}


	public function index()
	{
		for($i = 0; $i < count($this->evento); $i++){
			$this->evento[$i]['capa'] = json_decode( $this->evento[$i]['capa'], true);
		}

		$eventos = ($this->evento);

		return view("Loja::loggedin.eventos", compact('eventos'));
	}

	// lista tela de repositorios
	public function show($id, Request $request)
	{
		$evento = $this->evento->find($id);
		$evento->capa = json_decode($evento->capa, true);

		$repositorios = DB::table('events')
						->where('events.id', '=', $id)
						->join('produtos as prod', 'events.id', '=', 'prod.event_id')
						->leftJoin('alunos', 'prod.aluno_id', '=', 'alunos.id')
						->select( 'alunos.nome as nome_aluno', 'prod.nome as product_name', 'prod.id', 'prod.created_at as prod_data', 'prod.pin')
						->get();

		if(!Session::has('utils')){
		
			if( isset( $repositorios[0]->aluno_id)  ){
				$aluno_id = $repositorios[0]->aluno_id;
			}else{
				$aluno_id = 0;
			}
				
			$utils = [
				'evento_id' => $id,
				'aluno_id' => $aluno_id,
				'produto_id' => $repositorios[0]->id
			];

			$request->session()->put('utils', $utils );
		}

		return view("Loja::loggedin.repositorios", compact('repositorios', 'evento'));
	}


	public function checkPin(Request $request)
	{

		$validator = Validator::make( $request->all(), [
			'event_id' => 'required',
			'repositorio_id' => 'required',
			'pin' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json([ 'error' => 'O código PIN é obrigatório.'] , 200);
		}

		$repositorios = DB::table('produtos')->where( [
			['pin', '=', $request->input('pin')],
			['id', '=', $request->input('repositorio_id')]
		] )->get();


		if( count($repositorios) > 0 ){
			
			$utils = [
				'evento_id' => $repositorios[0]->event_id,
				'aluno_id' => $repositorios[0]->aluno_id,
				'produto_id' => $repositorios[0]->id
			];

			$request->session()->put('utils', $utils );

			return response()->json(
				[
					'success' => 'Você será redirecionado em breve', 
					'url' => url("/").'/galerias/'. $repositorios[0]->id
				],
				200);
		}else{
			return response()->json([ 'error' => 'O código PIN está incorreto.'] , 200);
		}
	}
}
