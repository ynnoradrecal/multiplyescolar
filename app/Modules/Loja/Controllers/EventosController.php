<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

use DB;
use Validator;
use Session;
use Response;

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
						->where('prod.status', '=', 1)
						->leftJoin('alunos', 'prod.aluno_id', '=', 'alunos.id')
						->select( 'events.parcelas', 'alunos.nome as nome_aluno', 'prod.thumb_small as src','prod.nome as product_name', 'prod.id', 'prod.created_at as prod_data', 'prod.pin')
						->get();
		
		if( count($repositorios) != 0 ) {

			if( isset( $repositorios[0]->aluno_id)  ){
				$aluno_id = $repositorios[0]->aluno_id;
			}else{
				$aluno_id = 0;
			}
				
			$utils = [
				'evento_id' => $id,
				'aluno_id' => $aluno_id,
				'produto_id' => $repositorios[0]->id,
				'parcelas_sem_juros' => $repositorios[0]->parcelas
			];

			$request->session()->put('utils', $utils );
			
		}

			

		// dd( $utils );
		

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
			return Response::json([ 'error' => 'O código PIN é obrigatório.'] , 200);
		}

		$gallery = \App\Models\Produtos::where([
			['id',  '=', $request->input('repositorio_id')],
			['pin', '=', $request->input('pin')]
		])->first();

		if ( true == boolval($gallery) )  {

			$event = \App\Models\Event::where('id', $gallery->event_id)->first();

			$nucleo = [

				'uids' => [
					'event_id'  => $gallery->event_id,
					'student_id'   => $gallery->aluno_id,
					'product_id' => $gallery->id,
				],

				'event' => [
					'interest_free' => $event->parcelas, // parcelas sem juros cobrado ao cliente
				]

			];

			Session::put('nucleo', $nucleo);

			return Response::json([
				'success' => 'Você será redirecionado em breve', 
				'url' => url("/").'/galerias/id/'. $gallery->id
			], 200);

		}

		return Response::json([ 'error' => 'O código PIN é inválido.'], 200);

	}
}
