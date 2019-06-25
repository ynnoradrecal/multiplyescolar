<?php 

namespace App\Modules\Admin\Response;

use Illuminate\Http\Request;
use Response;

class GaleriaResponse
{

	public function is_fail( $str )
	{
		return Response::json([
            'alert' => [
            	'title' => 'Falhou!',
            	'text'  => "Error: ". $str,
        		'type'  => 'fail'
            ]
        ],422);
	}

	static function is_create_success( $str ) 
	{
		return Response::json([
			'alert' => [
				'title' => 'Sucesso!',
	            'text'  => "Produto \"<b>". $str ."</b>\" criada com sucesso.",
	        	'type'  => 'success'
			]
        ],200);
	}

	static function is_update_success( $str ) 
	{
		return Response::json([
            'alert' => [
            	'title' => 'Sucesso!',
            	'text'  => "Produto \"<b>". $str ."</b>\" alterado com sucesso.",
        		'type'  => 'success'
            ]
        ],200);
	}

}