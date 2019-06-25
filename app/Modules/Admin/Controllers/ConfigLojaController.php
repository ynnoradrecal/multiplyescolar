<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;

use DB;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;

class ConfigLojaController extends Controller
{

	protected $view = 'Admin::sections.configuracao-loja';

	public function init()
	{

		$auth = Auth::guard('admin_user')->user();

        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

        return view( $this->view, [
            "login" => 1,
            'user' => $auth
        ] );

	}

	public function put(Request $req) 
	{

		$query = array();
		$nome = $req->input("nome") == "Contato" ? "contato" : "loja";

		$find = DB::table('admin_modulo_'. $nome)->get();
		$rules = $this->rulesQuery( $req->all() );

		$data = (array) $find[0];

		unset($data["created_at"], $data["updated_at"]);

		foreach( array_keys($data) as $i ) {

			if( $data[$i] != $rules[$i] ) {
				$query[$i] = $rules[$i];
			}

		}

		if( count( $query ) != 0 ) {
			$put = DB::table('admin_modulo_'. $nome)->update($query);
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
		$data = array(
			"modulos"=>"",
			"data"=>array(
				"loja"=>"",
				"contato"=>""
			)
		);
		
		$find = Configuracao::where("tipo", "=", "loja")->get(array("id", "nome", "slug"));
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
