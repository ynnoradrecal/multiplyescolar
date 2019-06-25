<?php
namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Models\Produtos;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GaleriasController extends Controller
{

	public function show( $id )
	{
		$galeria = DB::table('fotos_produto')->where('produto_id', '=', $id)->get();
		$produto = [
			'produto_id' => $id
		];
		return view("Loja::loggedin.galeria", compact('galeria', 'produto'));
	}

	public function confirm()
	{
		$galeria = DB::table('fotos_produto')->where('produto_id', '=', $id)->get();
		$produto = [
			'produto_id' => $id
		];
		return view("Loja::loggedin.galeria", compact('galeria', 'produto'));
	}

}
