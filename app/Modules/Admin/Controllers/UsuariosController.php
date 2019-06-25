<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use Input;
use DB;
use Image;
use Storage;
use Auth;

use App\Models\AdminUser;

use App\Modules\Admin\Services\CustomHelpers;

use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;


class UsuariosController extends Controller
{


	public $req;

    protected $view = "Admin::sections";

    public function __construct( Request $req )  
    {

        $this->req = $req;

    }


    public function init() 
    {

        $data = array();

        if( empty($this->req->input( "methods" )) ) {

            $auth = Auth::guard('admin_user')->user();

            $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

            return view( $this->view .'.usuario', [
                "login" => 1,
                'user' => $auth
            ] );

        }else{

            if( $this->req->input( "methods" ) ) 
            {
                return call_user_func_array(array(
                    $this, 
                    $this->req->input("methods")
                ), array());
            }

        }
    }

    protected function __show() 
    {
        
    	return DB::table('admin_usuarios')
    		->select('id', 'nome', 'email', 'password', 'foto', 'descricao')->get();

    }


    public function __save() {

    	$model = array();

    	$this->__validate();

    	$model = $this->req->input('model');
    	$model['password'] = bcrypt($model['password']); // cript senha

    	if($this->__user_exists($model)){
    		return array(
    			'status' => 'warning',
    			'message' => 'Usuário ja existente em nossa base de dados!'
    		);
    	}

    	if( isset($model['small']) && count($model['small']) != 0 ) {

    		foreach( $model['small'] as $item ) {
    			$model['foto'] = $item['thumb'];
    		}

    		unset($model['small']);

    	}

    	unset($model['confirmar']);

    	$id = DB::table('admin_usuarios')->insertGetId($model);

    	if($id) {

    		if( isset($model['foto']) ) {
    			$this->__transport_file($id, $model['foto']);
				$this->__clean_thumb_small('tmp');
			}

    		return array('status'=>'success');

    	}

    }

    public function __update() {

    	$model = array();
    	$id = $this->req->input('model.id');

    	$this->__validate();

    	$model = $this->__data_diff($id, $this->req->input('model'));

    	if( count($model) != 0 ) {

    		DB::table('admin_usuarios')->where('id', $id)->update($model);

    		if(isset($model['foto'])) {
    			$this->__transport_file($id, $model['foto']);
				$this->__clean_thumb_small('tmp');
    		}

    		return array('status'=>'success');

    	}

    	return array('status'=>'false');

    }

    public function __delete() {

    	$id = $this->req->input('id');

    	$users = DB::table('admin_usuarios')->select('email')->get();

    	foreach( $users as $item ) {
    		if( !empty( $item->foto ) ) {
    			$this->__clean_thumb_small($id);
    		}
    	}

    	if( DB::table('admin_usuarios')->where('id', $id)->delete() ) {
    		return array('status'=>'success');
    	}

    }

    public function __data_diff($id, $data) 
    {

    	$field = 'id,nome,email,password,descricao';
    	$lot = array();

    	unset($data['confirmar']);

    	$users = DB::table('admin_usuarios')->where('id', '=', $id)->get();
    	
    	foreach( explode(',', $field) as $i ) {

    		if( $users[0]->{$i} != $data[$i] ) {
    			$lot[$i] = $data[$i];
    		}

    	}

    	if( isset($data['small']) && count($data['small']) != 0 ) {

    		if($users[0]->foto != $data['small'][0]['thumb']) {
				$lot['foto'] = $data['small'][0]['thumb'];
    		}

    		unset($data['small']);
    	}
    	
    	if(isset($lot['password'])) {
    		$lot['password'] = bcrypt($lot['password']);
    	}

    	return $lot;

    }

    public function __user_exists( $data ) 
    {

    	$cont = 0;
    	$users = DB::table('admin_usuarios')->select('email')->get();

    	foreach( $users as $item ) {
    		if($item->email == $data['email']) {
    			$cont = 1;
    		}
    	}

    	return $cont;

    }

    protected function __validate() 
    {

        $rules = array(); $fields;

        $fields = "nome,email,password,confirmar";

        $rules["model.confirmar"] = "required|same:model.password";

        foreach( explode(",", $fields) as $field) {
            if( !in_array( $field, array("confirmar") ) ) {
            	$rules[ "model.". $field ] = "required";
            }
        }

        $this->validate($this->req, $rules);

    }


    public function __upload() {

    	$this->__clean_thumb_small('tmp');

        $file = Input::file('file');
        $path = '/uploads/usuarios/tmp';

        $tmp = $file->getRealPath();
        $name = md5(uniqid(rand(), true)) .".". $file->getClientOriginalExtension();

        $img = Image::make($tmp);

        $img->fit(128, 128, function ($constraint) {
            $constraint->upsize();
        });

        if( !Storage::disk('local')->exists( $path .'/'. $name ) ) {
            $img->save(public_path() . $path .'/'. $name);
        }

        return array(
            'data' => array(
                'local' => last(explode('/', $path)),
                'path' => str_replace('/tmp', '', $path),
                'thumb' => $name
            )
        );

    }

    public function __transport_file( $id, $foto ) {

        $directory = '/uploads/usuarios/tmp';
        $to = '/uploads/usuarios/'. $id;

        if( !Storage::disk('local')->exists( $to ) ) {
            Storage::makeDirectory($to);
        }

        foreach( Storage::allFiles($directory) as $file ) {
            Storage::move($file, $to .'/'. $foto);
        }

    }

    public function __clean_thumb_small( $local ) {

        $directory = '/uploads/usuarios/'. $local;

        foreach( Storage::allFiles($directory) as $file ) {

            if( Storage::disk('local')->exists( $file ) ) {
                Storage::delete($file);
            }

        }

    }


}