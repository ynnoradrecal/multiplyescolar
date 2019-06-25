<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\AdminModuloNav;
use App\Models\AdminGrupo;
use App\Models\AdminUser;
use App\Models\AuthAdministrator;

use App\Services\Upload;

use Input;
use Storage;
use Auth;
use Image;

use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;


class AdministrativoController extends Controller
{

    protected $fields;
    protected $rules;

    
    protected $data;

    
    protected $request;

    
    protected $view = "Admin::sections";

    
    protected $code = 200;


    protected $sector;


    // ----------------


    public function __construct( Request $request )  
    {

        $this->request = $request;
        $this->sector = $this->request->input("sector");

    }

    // MAIN ----------------

    public function init() 
    {

        if( $this->request->input( "methods" ) ) {
            call_user_func_array(array($this, $this->request->input("methods")), array());
        }
        
        if( count($this->data) != 0 ) {
            return response()->json( $this->data, $this->code );
        }

    }

    public function usuario() 
    {

        $auth = Auth::guard('admin_user')->user();
        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

        return view( $this->view .".usuario", [
            "login" => 1,
            'user' => $auth
        ] );
    }

    public function grupo() 
    {
        return view( $this->view .".grupo", [
            "login" => 1
        ] );
    }

    // CRUD ----------------

    protected function get() 
    {
        if( $this->sector == "user" ):
            $this->data = AdminUser::all();
        else:
            $this->data = AdminGrupo::all();
        endif;
    }

    protected function save()
    {

        $this->rulesValidate();

        // permissão do administrador
        if( $this->authAdministrator() ) {

            if( $this->request->input("sector") == "user" ){
                $save = AdminUser::create( $this->rulesQuery() );
            }else{
                $save = AdminGrupo::create( $this->rulesQuery() );
            }
            
            $this->data = array("id" => $save->id);
            $this->code = 200;
            
        }
        
    }

    protected function put() 
    {
   
        $this->rulesValidate();

        if( $this->authAdministrator() ){

            if( $this->sector  == "user" ){
                $put = new AdminUser;
            }else{
                $put = new AdminGrupo;
            }

            $put->where("id", "=", $this->request->input("post.id"))
                ->update( $this->rulesQuery() );

            $this->data = $put->find( $this->request->input("post.id") );
            $this->code = 200;
        
        }

    }

    protected function destroy() 
    {

        if( $this->authAdministrator() ) {
            if( $this->sector == "user" ){
                
                $file = $this->request->input("file.url");

                if( !empty( $file ) ) {
                    $this->deleteFileDirectory( $file );
                }

                AdminUser::where('id', "=", $this->request->input("post.id"))->delete();

            }else{

                AdminGrupo::where('id', "=", $this->request->input("id"))->delete();

            }
        }
  
    }

    // AUTH ADMINISTRATOR----------------

    protected function authAdministrator()
    {

        $this->validate($this->request, array(
            "post.admin.senha" => "required"
        ));

        $auth = AuthAdministrator::find(1);
        $data = $auth->toArray();

        if ( !Hash::check($this->request->input("post.admin.senha"), $data["senha"]) ) {
            
            $this->data = array(
                "alert"=>"warning",
                "slug"=>"authadmin",
                "title"=>"Autenticação Administrativa",
                "message"=>"Senha do administrador não locazida."
            );

            $this->code = 422;

            return false;

        }   

        return true;

    }

    // REGRAS DE QUERY----------------

    protected function addAvatarRulesQuery() 
    {   

        $rules = "";

        if( !empty($this->request->input("file.url")) ) {
            $rules = json_encode(array(
                "url"  => $this->request->input("file.url")
            ));
        }

        return $rules;

    }

    protected function rulesQuery() 
    {

        $methods = $this->request->input("methods");
        $sector  = $this->request->input("sector");

        $rules;

        if( $sector == "user" ){
            
            if( $methods == "save" ) {
                $this->rulesQueryInsert( 
                    array(
                        "nome,email,senha,id_grupo,descricao",
                        array(
                            "senha", "foto"
                        )
                    ) 
                );
            }

            if( $methods == "put" ) {
                $this->rulesQueryPut();
            }

        }else{

            if( $methods == "save" ) {
                $this->rulesQueryInsert( 
                    array(
                        "nome,descricao,tree",
                        array()
                    ) 
                );
            }

            if( $methods == "put" ) {
                $this->rulesQueryPut();
            }

        }

        $rules = $this->rules;

        foreach( explode(",", substr($this->fields, 0, -1)) as $field ) {
            if( !in_array( $field, array("tree", "senha") ) && !empty( $field ) ) {
                $rules[$field] = $this->request->input("post.". $field );
            }
        }

        return $rules;

    }

    protected function rulesQueryPut() 
    {
        $users = AdminUser::find( $this->request->input("post.id") );
        $users = $users->toArray();

        $post = $this->request->input("post");

        $this->fields = $this->fieldAltForActionPut( 
            array(
                $users,
                $post
            ) 
        );

        if ( $post["senha"] != $users["senha"] ) {
            $this->rules["senha"] = bcrypt( $this->request->input("post.senha") );
        }

        if( isset( $post["foto"] ) && json_encode($post["foto"]) != $users["foto"] ) {
            $this->rules["foto"] = $this->addAvatarRulesQuery();
        }

    }

    protected function rulesQueryInsert( $data ) 
    {

        list( $fields, $rules ) = $data;

        $this->fields = $fields; 

        if( implode(",", $rules) == "senha,foto" ) { // se for sector user
            $this->rules["senha"] = bcrypt( $this->request->input("post.senha") );
            $this->rules["foto"]  = $this->addAvatarRulesQuery();
        }else{
            $this->rules["nivel"] = json_encode( $this->request->input("post.tree") );
        }

    }

    protected function fieldAltForActionPut( $data ) 
    {

        $field = "";
        list( $users, $post ) = $data;

        unset($post["confirmar"], $post["foto"], $post["admin"]);

        foreach( $post as $i => $item ) {
            if( trim($post[$i]) != trim($users[$i]) ) {
                $field .= $i .","; 
            }
        }

        return $field;

    }

    // VALIDAÇÃO ----------------

    protected function rulesValidate() 
    {

        $rules = array(); $fields;

        if( $this->sector == "user" ):

            $fields = "nome,email,senha,confirmar,id_grupo";
            $rules["post.confirmar"] = "required|same:post.senha";

        else:

            $fields = "nome,tree";
            if( count( $this->request->input("post.tree") ) == 0 )
                $rules["post.tree"] = "required";

        endif;

        foreach( explode(",", $fields) as $field) {
            if( !in_array( $field, array("tree", "confirmar") ) ) 
                $rules[ "post.". $field ] = "required";
        }

        $this->validate($this->request, $rules);

    }

    // AVATAR ----------------

    public function __avatar() 
    {

        dd(Input::file('file'));

        $file  = Input::file('file');
        $dest  = "/uploads/avatar";



    }

    public function avatar() 
    {

        $arr = array();

        foreach( Input::file('foto') as $file ) {

            $name = "/". md5(uniqid(rand(), true));

            $arr = array(
                'url'  => '/uploads/avatar'. $name .".jpg",
            );

            $file->move( public_path() .'/uploads/avatar', $name .".jpg" );

        }

        return $arr;

    }

    protected function destroyAvatar() 
    {

        $id = $this->request->input("id");

        if( !empty( $id ) ) {

            $user = AdminUser::find( $id );

            $user->where("id", "=", $id)->update( array("foto"=>"") );

        }

        $this->deleteFileDirectory( $this->request->input("file.url") );

    }

    protected function deleteFileDirectory( $file ) 
    {
        if( Storage::disk('local')->exists( $file ) ){

            Storage::delete($file);

            $this->data = array("status"=>1, "message"=>"Arquivo removida com sucesso!" );

        }else{
            $this->data = array("status"=>"error", "message"=>"Falha ao remover arquivo!");
            $this->code = 422;
        }
    }

    // OUTROS ----------------

    protected function getTree() 
    {
        $this->data = AdminModuloNav::all();
    }

    protected function getGroup() 
    {
        $this->data = AdminGrupo::all();
    }

}