<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Classe que gerencia as Políticas de compra
class PoliticasController extends Controller
{
 		
	public function show($id)
	{
		
		$politicas = DB::table('rel_politica_produto')
			->where('produto_id' ,'=', $id)
			->join('politicas as pol', 'pol.id', '=', 'rel_politica_produto.politica_id')
			->join('produtos as prod', 'rel_politica_produto.produto_id', '=', 'prod.id')
			->select('prod.*', 'pol.*', 'rel_politica_produto.produto_id as produto_id', 'rel_politica_produto.politica_id as politica_id')
			->get();

		return view("Loja::loggedin.politicas", compact("politicas"));

	}

}
