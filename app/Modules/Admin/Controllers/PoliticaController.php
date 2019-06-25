<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Politica;

use Input;
use Storage;
use Image;
use Auth;

use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;


class PoliticaController extends Controller
{

    public $req;

    protected $view = "Admin::sections";

    public function __construct( Request $req )  
    {
        $this->req = $req;
    }

    public function index() 
    {

        $auth = Auth::guard('admin_user')->user();

        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

        return view( $this->view .'.politica', [
            "login" => 1,
            'user' => $auth
        ] );
    }

    public function show() 
    {
        return Politica::all();
    }

    public function store() 
    {

        $this->validate($this->req, $this->rules());

        $store = Politica::create( $this->queryRules( "insert" ) );

        if( $store ) {
            return response()->json(array(
                'alert' => array(
                    "title"=>"Sucesso!",
                    "text" =>"Politica ". $this->req->input("nome") ." criada com sucesso.",
                    "type" =>"success"
                )
            ), 200);
        }

    }

    public function put() 
    {

        $put = Politica::where("id", "=", $this->req->input("id"))
                ->update( $this->queryRules( "update" ) );

        if( $put ) {
            return response()->json(array(
                'data' => array(
                    'path' => '/uploads/politica/'. str_slug($this->req->input("nome"), "-")
                ),
                'alert' => array(
                    "title"=>"Sucesso!",
                    "text" =>"Politica ". $this->req->input("nome") ." alterada com sucesso.",
                    "type" =>"success"
                )
            ), 200);
        }

    }

    public function destroy() 
    {

        $id = $this->req->input("id");

        $directory = '/uploads/politica/'. str_slug($this->req->input('nome'), '-');

        if( Storage::disk('local')->exists($directory) ) {
            Storage::deleteDirectory($directory);
        }

        Politica::where('id', "=", $id)->delete();

        return array(
            'alert' => array(
                "title"=>"Sucesso!",
                "text" =>"Politica ". $this->req->input("nome") ." deletada com sucesso.",
                "type" =>"success"
            )
        );

    }

    protected function queryRules( $type ) 
    {

        $rules = array();

        if( $type == "insert" )
            $rules = $this->queryRulesStore();

        if( $type == "update" )
            $rules = $this->queryRulesPut();

        return $rules;

    }

    protected function queryRulesStore() 
    {


        $fields = array("nome", "tipo", "quantidade", "descricao");
            
        $rules["slug"] = str_slug($this->req->input("nome"), "-");
        //$rules["campos"] = json_encode($this->req->input("campos"));

        foreach( $fields as $field ) {
            $rules[$field] = $this->req->input($field);
        }

        return $rules;

    }

    protected function queryRulesPut()
    {
        
        $post = $this->req->all();        
        $find = Politica::find( $this->req->input("id") ); // get data for id        
        $data = $find->toArray();

        $post["slug"] = str_slug($this->req->input("nome"), "-"); // get slug
        $post["list"] = count($post["list"]) != 0 ? json_encode( $post["list"] ) : ""; // parse json list

        // verificando se a necessidade de um update
        $rules = array();
        foreach( array_keys( $post ) as $i ) {
            if( $data[$i] != $post[$i] ) {
                $rules[$i] = $post[$i];
            }
        }

        $path  = '/uploads/politica/'. $data['slug']; // images path
        $files = array();

        if( Storage::disk('local')->exists( $path ) ){
            $files = Storage::files( $path ); // get images
        }
        
        $images = array();

        if( !empty($rules['list']) ) {

            $list = json_decode($rules['list'], true);

            foreach ($list as $i => $item) {

                $list[$i]['path'] = '/uploads/politica/'. $post['slug'];

                foreach (array_keys($item['images']) as $x) {
                    $images[] = $item['images'][$x]['image'];
                }

            }

            $rules['list'] = json_encode($list);
            $rules['list'] = str_replace('\/uploads\/tmp\/', '', $rules['list']);

        }

        // remove images lot
        if( count($files) != 0 ) {

            foreach ($files as $i => $item) {

                $files[$i] = substr($files[$i], strlen($path));

                if( !in_array( $files[$i], $images ) ) {
                    Storage::delete( $path .'/'. $files[$i] );
                }

            }

        }

        // transport images
        if( in_array("list", array_keys($rules)) || $post['slug'] != $data['slug'] ) {

            $this->transport( $images, '/uploads/politica/'. $post["slug"] );

        }
        
        return $rules;

    }


    protected function rules() 
    {

        $rules = array(
            "nome" => "required",
            "tipo" => "required",
            "quantidade" => "required"
        );

        if( count($this->req->input("campos")) != 0 ) {
            $rules["campos"] = "required";
        }

        return $rules;

    }

    public function upload() 
    {   

        $res = array(); // response

        if( $this->req->input( "methods" ) ) {
            $res = call_user_func_array(array(
                $this, 
                $this->req->input("methods")
            ), array());
        }

        return response()->json(array(
            "data"=>$res["data"], 
            "message"=>$res["message"]
        ), $res["code"]);

    }

    public function transport( $list, $to ) 
    {

        // criando novo diretorio
        if(!Storage::disk('local')->exists( $to )) {
            Storage::makeDirectory( $to );            
        }

        foreach( $list as $i => $item ) {

            $tmp = substr($item, 0, strpos($item, 'p/')) .'p';

            if( $tmp == '/uploads/tmp' ) {
                    
                $image = substr($item, strlen($tmp) + 1);                
                Storage::move($tmp .'/'. $image, $to .'/'. $image);

            }

        }

    }

    protected function saveFileUpload() 
    {
        $file = Input::file('file');
        $tmp  = $file->getRealPath();
        $name = md5(uniqid(rand(), true)) .".". $file->getClientOriginalExtension();
        $to   = "/uploads/tmp";

        $img = Image::make($tmp);

        $img->fit(292, 300, function ($constraint) {
            $constraint->upsize();
        });

        $img->save(public_path() . $to ."/". $name);

        return array(
            "data"=>array(
                "name" => $file->getClientOriginalName(),
                "path" => $to,
                "image" => $name
            ),
            "message" => array(),
            "code" => 200,
        );;
        
    }

    protected function destroyFileUpload() 
    {

        $id = $this->req->input("id");
        $x  = array(); // ponteiro de localização da imagem
        $to = "/uploads/tmp";

        if( empty($id) ) {

            $image = $to ."/". $this->req->input("image");
            $this->destroyImageDir( $image );

        }else{
            $policy = Politica::where("id", "=", $id)->get(array("list"));

            $data   = $policy->toArray()[0];
            $list   = json_decode( $data["list"], true );

            if( count($list) != 0 ) {
                foreach( $list as $i => $item ) {    
                    if( $this->req->input("idFoto") == $list[$i]["id"] ) {
                        $destroy = $this->destroyImageDir( $list[$i]["imagem"] );
                        $x = $i;
                    }
                }
            }else{
                $this->destroyImageDir( $this->req->input("imagem") );
            }

            if( isset($destroy) ) {
                $list[$x]["imagem"] = "";
                $put = Politica::where("id", "=", $id)->update( array("list"=>json_encode($list)) );
            }
        }
        
        return array(
            "data"=>"",
            "message"=>array(
                "title"=>"Sucesso!",
                "text" =>"Imagem removida com sucesso!",
                "type" =>"success"
            ),
            "code" => 200,
        );

    }

    protected function destroyImageDir( $file ) 
    {   

        if( !Storage::disk('local')->exists( $file ) )
            return false;

        Storage::delete($file);

        return true;

    }

}