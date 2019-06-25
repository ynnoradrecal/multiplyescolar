<?php

namespace App\Modules\Admin\Controllers;

use DB;
use Auth;

use Illuminate\Http\Request;

use App\Models\Configuracao;
// use App\Models\Correio;
// use App\Models\FreteGratis;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class DeliveryMethodsController extends Controller
{

	protected $tipo = 'frete';

	protected $view = 'Admin::sections.delivery-methods';

	public function init()
	{
		$data = Configuracao::where('tipo','=', $this->tipo)->get();

		$auth = Auth::guard('admin_user')->user();
        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

        $user = $auth;
        $login = 1;

		return view($this->view, compact('data', 'user', 'login'));
	}

	public function put(Request $req) 
	{

		$query = array();

		$nome = $req->input("nome");
		
		$modulos = array(
			'Correios' => 'correios',
			'Frete Grátis' => 'frete_gratis',
			'Transportadora' => 'transportadora',
			'Retirar no Local' => 'retirar_no_local'
		);

		$find = DB::table('admin_modulo_'. $modulos[$nome])->get();
		$rules = $this->rulesQuery( $req->all() );

		$data = (array) $find[0];

		unset($data["created_at"], $data["updated_at"]);

		foreach( array_keys($data) as $i ) {

			if( $data[$i] != $rules[$i] ) {
				$query[$i] = $rules[$i];
			}

		}

		if( count( $query ) != 0 ) {
			$put = DB::table('admin_modulo_'. $modulos[$nome])->update($query);
		}

		if( isset($put) ) {
			return array(
				"title"=>"Sucesso",
				"text"=>"Alteração do modulo <b>". $req->input("nome") ."</b> realizado com sucesso!",
				"type"=>"success",
			);
		}else{
			return array(
				"title" => "Aviso!",
				"text" => "Não há alteração nos dados!",
				"type" => "warning"
			);
		}

	}

	public function rulesQuery( $data ) 
	{

		$rules = array();

		unset($data["created_at"], $data["updated_at"], $data["nome"]);

		foreach( array_keys( $data ) as $i ) {
			$rules[$i] = $data[$i];
		}

		return $rules;

	}

	public function modulos() 
	{

		$type = 'frete';

		$data = array(
			"modulos"=>"",
			"data"=>array(
				"correios"=>"",
				"frete_gratis"=>"",
				"retirar_no_local"=>"",
				'transportadora'=>''
			)
		);
		
		$find = Configuracao::where("tipo", "=", $type)->get(array("id", "nome", "slug"));
		$data["modulos"] = $find->toArray();


		foreach( array_keys($data["data"]) as $i ) {
			 $data["data"][$i] = $this->getDataModule( $i );
		}

		return $data;

	}

	public function getDataModule( $nome ) 
	{

		return DB::table('admin_modulo_'. $nome)->get();

	}

}
