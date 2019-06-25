<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Input;
use Storage;
use Image;
use Auth;

use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;


class FotosController extends Controller
{

    public $req;

    protected $view = "Admin::sections";

    public function __construct( Request $req )  
    {
        
        $this->req = $req;

    }

    public function init() 
    {

        $auth = Auth::guard('admin_user')->user();
        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);
        
        if( empty($this->req->input( "methods" )) ) {

            return view( $this->view .".fotos", array(
                "login" => 1,
                'user' => $auth
            ) );

        }else{

            if( $this->req->input( "methods" ) ) {
                $data = call_user_func_array(array($this, $this->req->input("methods")), array());
            }

            return $data;

        }
    }

    public function Upload() 
    {

        $file  = Input::file('file');
        $image = array();

        $id    = $this->req->input("id");
        // $dir   = str_slug($this->req->input("nome"), '-');
        $to    = "/uploads/repositorio";
        $path  = public_path() . $to;

        if( !file_exists( $path. "/".$id) ) {
            mkdir( $path ."/".$id, 0755 );
        }

        $mask  = public_path() .'/images/mask.png';

        $tmp  = $file->getRealPath();
        $file_name = md5(uniqid(rand(), true)) .".". $file->getClientOriginalExtension();
        $name = head(explode('.', $file->getClientOriginalName()));

        $img = Image::make($tmp);
        $watermark = Image::make($mask);

        $img->insert($watermark, 'center');

        $img->save($path."/".$id ."/". $file_name);

        $thumb  = $path .'/'. $id .'/thumb';
        $height = array(228, 512, 342); // variações de altura

        //$img->resize(342, 228);
        $img->crop(332, $height[rand(0, 2)]);

        if( !file_exists( $thumb ) ) {
            mkdir( $thumb, 0755 );
        }

        $img->save($thumb .'/'. $file_name);


        $id = DB::table("fotos_produto")->insertGetId(
            array(
                "produto_id"=>$id,
                'name' => $name,
                "url"=>$to."/".$id ."/". $file_name
            )
        );

        return array(
            "status"=>"success",
            "image"=>array(
                "id"=>$id,
                "name"=>$name
            )
        );

    }

    public function removeFile() 
    {
        
        $id = $this->req->input("id");

        $find = DB::table("fotos_produto")
            ->select("url")->where("id", "=", $id)->get();

        $file = $find[0]->url;

        $this->destroyFileDir( $file );

        DB::table('fotos_produto')->where('id', '=', $id)->delete();

        return response()->json(array(
            "status"=>"success",
        ), 200);

    }

    protected function destroyFileDir( $file ) 
    {   

        if( !file_exists( public_path() . $file ) ) {
             return false;
        }           

        return unlink(public_path() . $file);

    }

    public function getProdutos() 
    {

        $table = DB::table( "produtos" );

        $query = $table->leftJoin('events', function($join) {
            $join->on('events.id', '=', 'produtos.event_id');
        })->leftJoin('alunos', function($join) {
            $join->on('alunos.id', '=', 'produtos.aluno_id');
        })->select(
            "produtos.id", 
            "produtos.nome as pr_nome", 
            "events.name as ev_nome", 
            "alunos.nome as al_nome",
            "produtos.foto_unit_val as preco",
            "produtos.status"
        );

        $find = $query->get();

        return $find;
            
    }


    public function DelImage() 
    {

        $data = $this->req->input('data');
        
        $path = str_replace(substr(strrchr($data['url'], "/"), 1), '', $data['url']);

        $image = substr($data['url'], 1);
        $thumb = substr($path .'thumb/'. substr(strrchr($image, "/"), 1), 1);
        
        foreach( Storage::files($path) as $files ) {

            if( $files == $image ) {

                Storage::delete($image);
                Storage::delete($thumb);

            }

        }
        
        DB::table('fotos_produto')->where('id', '=', $data['id'])->delete();

    }

    public function getFotos() 
    {
        
        $table = DB::table("fotos_produto");
        
        $query = $table->where("produto_id", "=", $this->req->input("id"));

        $find  = $query->get();

        return $find;

    }

    public function DelAllRepository() 
    {

        $table = 'fotos_produto';
        $data = $this->req->input('data');
        $id   = $data['id'];

        $find = DB::table($table)
            ->where('produto_id', '=', $id)
            ->get();

        foreach( $find as $item ) {
            if( Storage::disk('local')->exists( substr($item->url, 1) ) ) {
                Storage::delete(substr($item->url, 1));
            }
        }

        DB::table($table)->where('produto_id', '=', $id)->delete();


    }



}