<?php

namespace App\Modules\Beta\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;
use Session;
use Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Classe que gerencia as Políticas de compra
class PoliticasController extends Controller
{

	public function show($id)
	{
		
		$nucleo = Session::get('nucleo');

		$politicas = DB::table('rel_politica_produto')
		->where('produto_id' ,'=', $id)
		->join('politicas as pol', 'pol.id', '=', 'rel_politica_produto.politica_id')
		->join('produtos as prod', 'rel_politica_produto.produto_id', '=', 'prod.id')
		->select('prod.*', 'pol.*', 'rel_politica_produto.produto_id as produto_id', 'rel_politica_produto.politica_id as politica_id')
		->get();

		if(count($politicas) == 0){
			return redirect('frete');
		}

		$event = (object) $nucleo['event'];
		$uids  = (object) $nucleo['uids'];

		return view("Beta::loggedin.politicas", compact("politicas", 'event', 'uids'));

	}

	public function showPolicys() 
	{	

		$exists = Session::has('nucleo');

		if( $exists ) {

			$nucleo = Session::get('nucleo');

			return Response::json([
				'policys' => $nucleo['policys']
			], 200); 

		}

		return true;

	}

}
