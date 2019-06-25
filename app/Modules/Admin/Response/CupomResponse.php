<?php 

namespace App\Modules\Admin\Response;

use Validator;
use Illuminate\Http\Request;

class CupomResponse
{

	public function __construct()
	{
		// ....
	}

	static function StoreIsSuccess( $req )
	{
		return response()->json(array(
            'title' => 'Sucesso!',
            'text'  => 'Cupom '. $req->input('post.name') .'cadastrado!',
            'type'  => 'success'
        ), 200);
	}

	static function UpIsSuccess( $req )
	{
		return response()->json([
            'title' => 'Sucesso!',
            'text'  => 'Cupom '. $req->input('post.name') .'atualizado!',
            'type'  => 'success'
        ], 200);
	}

	static function DestroyIsSuccess( $req )
	{
		return response()->json([
            'title' => 'Sucesso!',
            'text'  => 'Cupom '. $req->input('post.name') .'deletado!',
            'type'  => 'success'
        ], 200);
	}

	static function ShowData( $collection )
	{
		return response()->json(array(
			'data' => $collection
		), 200);
	}

}