<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Models\Politica;
use App\Models\Event;
use App\Models\Aluno;
use App\Models\RelPoliticaProdutos;
use App\Models\Produtos;

use Input;
use DB;
use Image;
use Storage;
use Auth;

use App\Modules\Admin\Services\CustomHelpers;
use App\Modules\Admin\Services\Upload;
use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;

use App\Modules\Admin\Services\Galeria;
use App\Modules\Admin\Requests\GaleriaRequest;
use App\Modules\Admin\Response\GaleriaResponse;


class ProdutosController extends Controller
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

            return view( $this->view .'.produtos', [
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

    protected function show() { 

        $rel = array(); $ids = array();

        $product = Produtos::all();
        $data    = $product->toArray();

        foreach( $data as $i => $item ) {

            $rel[$i] = RelPoliticaProdutos::where("produto_id", "=", $item["id"])->get(array("politica_id"));
            $data[$i]["policys"] = $rel[$i]->toArray();

            $rel_delivery[$i] = DB::table('rel_servico_entrega')->where('produto_id', '=', $item['id'])->select('modulo_id')->get();
            $data[$i]["delivery"] = $rel_delivery[$i];

        }

        return $data;
    }

    public function save( GaleriaRequest $req ) {

        $gal = new Galeria();
        
        $gal->get($req->input('post'))
            ->filter()
            ->format_money()
            ->product()    // save product
            ->transport()  // transporte de arquivo
            ->delivery()   // save serviço de entrega
            ->policys()    // save politica de compra
            ->create_new_directory(); // criar diretorio do produto
        
        return GaleriaResponse::is_create_success($req->input('post.nome'));

    }

    public function update( GaleriaRequest $req )
    {

        $gal = new Galeria();

        $gal->get_id($req->input('post.id'))
            ->get($req->input('post'))
            ->filter()
            ->validate_new_data()
            ->format_money()
            ->product()
            ->transport()
            ->delivery()
            ->policys();

        return GaleriaResponse::is_update_success($req->input('post.nome'));

    }

    protected function delete() {

        $post = $this->req->input("post");
        $id   = $post["id"];

        $path = '/uploads/repositorio/';
        $dir  = $path . $id;
        // $dir  = $path . $id . str_slug($post['nome'], '-');

        if( Storage::disk('local')->exists($dir) ) {
            Storage::deleteDirectory($dir);
        }

        DB::table('fotos_produto')->where('produto_id', '=', $id)->delete();
        
        Produtos::where("id", "=", $id)->delete();
        RelPoliticaProdutos::where("produto_id", "=", $id)->delete();

        return array(
            "alert"=>array(
                "title" => "Sucesso!",
                "text"  => "Politica \"<b>". $post["nome"] ."</b>\" deletada com sucesso.",
                "type"  => "success"
            ),
            "code"=>200
        );
    }


    public function getPolicy() {

        return array(
            "data"=>Politica::get(array("id", "nome")),
            "code"=>200
        );
    }

    public function getAlunos() {

        return array(
            "data"=>Aluno::get(array("id", "nome")),
            "code"=>200
        );
    }

    public function getEvents() {

        return array(
            "data"=>Event::get(array("id", "name")),
            "code"=>200
        );
    }

    public function decimal( $valor ) 
    {
        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    private function __get_type_service() 
    {
        $find = DB::table('admin_modulos')->where('tipo', '=', 'frete')->get();
        return $find;
    }

    public function upload() 
    {

        $this->__clean_thumb_small('tmp');

        $file = Input::file('file');
        $path = '/uploads/repositorio/tmp';

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
                'path' => $path,
                'thumb' => $name
            )
        );

    }

    public function __clean_thumb_small( $local ) {

        $directory = '/uploads/repositorio/'. $local;

        foreach( Storage::allFiles($directory) as $file ) {

            if( Storage::disk('local')->exists( $file ) ) {
                Storage::delete($file);
            }

        }

    }

    public function __get_instituicoes() {

        return DB::table('instituicoes')->get();

    }


}