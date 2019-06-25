<?php

namespace App\Modules\Admin\Controllers;

use App\Models\Configuracao;
use App\Models\ConfigFacebook;
use App\Models\ConfigGoogle;

use DB;
use Tracker;
use Storage;
use Input;
use Auth;
use Image;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;

class DeveloperConfigsController extends Controller
{

	protected $view = 'Admin::sections.develop-configs';
	
	public function init()
	{

		$auth = Auth::guard('admin_user')->user();

        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

        return view( $this->view, [
            "login" => 1,
            'user' => $auth
        ] );

	}

	public function destroyImagem( Request $req ) 
	{
		$this->destroyImageDir( $req->input("file") );
		$put = DB::table('admin_modulo_facebook')->update(array("file"=>""));
		if( isset($put) ) {
			return array(
				"title"=>"Sucesso",
				"text"=>"Imagem Removida com sucesso!",
				"type"=>"success",
			);
		}
	}

	protected function destroyImageDir( $file ) 
    {   

        if( !Storage::disk('local')->exists( $file ) )
            return false;

        Storage::delete($file);

        return true;

    }

	public function upload( Request $req )
	{

		$path = public_path();
		$directory = $path .'/uploads/facebook';
		$file = Input::file('file');

		$tmp = $file->getRealPath();
		$image = md5(uniqid(rand(), true)) .".". $file->getClientOriginalExtension();; // nova imagem

		$img = Image::make($tmp);

		if( !Storage::disk('local')->exists( $directory .'/'. $image ) ) {

			$img->save( $directory .'/'. $image );

			return array(
				'file' => array(
					'path' => '/uploads/facebook',
					'image' => $image,
				)
			);

		}

	}

	// ------------------------------------------------------

	public function put(Request $req) 
	{

		$query = array();
		$nome  = $req->input("nome") == "Google" ? "google" : "facebook";

		$find = DB::table('admin_modulo_'. $nome)->get();
		$rules = $this->rulesQuery( $req->all() );

		$data = (array) $find[0];

		unset($data["created_at"], $data["updated_at"]);

		foreach( array_keys($data) as $i ) {

			if( $data[$i] != $rules[$i] ) {
				$query[$i] = $rules[$i];
			}

		}

		if( isset($query['file']) ) {

			if( empty($query['file']) ) {
				
				$query['file'] = '';

				foreach (Storage::allFiles('/uploads/facebook') as $key => $item) {
					Storage::delete($item);
				}

			}else{
				$query['file'] = json_encode($query['file']);
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
				"facebook"=>"",
				"google"=>""
			)
		);
		
		$find = Configuracao::where("tipo", "=", "developer")->get(array("id", "nome", "slug"));
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
