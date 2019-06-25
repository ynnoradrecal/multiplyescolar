<?php
namespace App\Modules\Beta\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;

use App\Models\Produtos;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GaleriasController extends Controller
{

	public function show( $id )
	{

		$data = DB::table('fotos_produto')->where('produto_id', $id)->paginate(12);

		$gallery = \App\Models\Produtos::where('id', $id)->first();
		$event   = \App\Models\Event::where('id', $gallery->event_id)->first();

		$nucleo = Session::get('nucleo');

		$nucleo['event']['name'] = $event->name;
		$nucleo['event']['gallery'] = $gallery->nome;

		Session::put('nucleo', $nucleo);

		$produto = [
			'produto_id' => $id,
		];

		return view("Beta::loggedin.galeria", compact('data', 'produto', 'gallery', 'event'));
		

	}


	public function showJson( $id )
	{
		$galeria = DB::table('fotos_produto')->where('produto_id', '=', $id)->paginate(30);

		return $galeria;

		$produto = [
			'produto_id' => $id
		];
		return view("Beta::loggedin.galeria", compact('galeria', 'produto'));
	}

}
