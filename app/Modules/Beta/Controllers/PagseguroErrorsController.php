<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Models\PagseguroError;
use DB;
use Validator;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Classe que gerencia as Políticas de compra
class PagseguroErrorsController extends Controller
{
 	public function index(Request $request){
		
		$erro = PagseguroError::create([
			'client_id' => $request->input('client_id'),
			'code' =>	$request->input('code'),
			'message' => $request->input('message')
		]);

		return $erro;
	}

}