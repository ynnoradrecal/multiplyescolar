<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\Aluno;
use App\Models\RelContsEnd;
use App\Models\Instituicao;

use App\Modules\Admin\Services\Accounts;

use DB;
use Input;
use Storage;
use Exception;
use Auth;

use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;

class AccountsController extends Controller
{

    protected $view = "Admin::sections.accounts";

    protected $request;

    public function __construct(Request $request) 
    {
        $this->request = $request;
    }

    public function init()
    {

        if( $this->request->input( "methods" ) ) {
            return call_user_func_array(array($this, $this->request->input("methods")), array());
        }else{

            $auth = Auth::guard('admin_user')->user();

            $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

            return view( $this->view, [
                "login" => 1,
                'user' => $auth
            ] );

        }

    }

    public function __validation( $tdc ) 
    {

        if($tdc == 'instituicao') {
            $this->validate($this->request, array(
                'post.nome' => 'required'
            ));
        }

        if($tdc == 'alunos') {

            $this->validate($this->request, array(
                'post.nome' => 'required',
                'post.instituicao' => 'required',
                'post.responsavel' => 'required',
                'post.email' => 'required'
            ));

        }

    }


    public function __set_post_address( $data ) {

        $itens = 'logradouro,estado,cidade,cep,bairro,numero'; // campos do endereco

        foreach( $data as $i => $item ) {
            if( !in_array( $i, explode(',', $itens) ) ) {
                unset($data[$i]);
            }
        }

        return $data;

    }

    public function __set_post_person( $tdc, $data ) {

        $itens = $tdc == 'instituicao' ? 'nome,descricao' : 'nome,instituicao,responsavel,email,data_nascimento,rg_cpf,telefone,celular,descricao';
        
        foreach( $data as $i => $item ) {
            if( !in_array( $i, explode(',', $itens) ) ) {
                unset($data[$i]);
            }
        }

        return $data;

    }
   
    public function save() 
    {

        $tdc  = $this->request->input('form'); // tipo de conta
        $data = $this->request->input('post');

        $table = $tdc == "instituicao" ? "instituicoes" : $tdc; // tabela do db relacionada ao tipo de conta
    
        $this->__validation( $tdc );

        $person = $this->__set_post_person( $tdc, $data );
        $address = $this->__set_post_address( $data ); 

        $id_conta = DB::table($table)->insertGetId($person); // salvando info persoais
        $id_endereco = DB::table('enderecos')->insertGetId($address); // salavando endereco

        // salavando relacionamento
        DB::table("rel_conts_ends")->insert(array(
            'id_conta' => $id_conta,
            'tipo_de_conta' => $tdc,
            'id_endereco' => $id_endereco
        ));
        
        return $this->__response( $tdc, 'salva com sucesso.' );
        
    }

    public function put() 
    {
        
        $tdc  = $this->request->input('form'); // tipo de conta
        $data = $this->request->input('post');

        $id   = $data['id'];

        $table = $tdc == "instituicao" ? "instituicoes" : $tdc; // tabela do db relacionada ao tipo de conta
        unset($data['id']);

        if( count( $data ) == 0 ) {
            return array(
                'alert' => array(
                    'title'  => 'Aviso!',
                    'text'   => 'Não existe alteração nos dados<br> para executar essa ação.',
                    'outros' => 'Clientes',
                    'type'   => 'warning'
                )
            );
        }

        $person = $this->__set_post_person( $tdc, $data ); // filtrar info
        $address = $this->__set_post_address($data); // filtrar endereco 

        // enderecos relacionado ao id da conta
        $rels = DB::table('rel_conts_ends')->select('id_endereco')->where('id_conta', '=', $id)->get();

        if( count($person) != 0 ) {
            DB::table($table)->where('id', '=', $id)->update($person);
        }

        if( count($address) != 0 ) {
            foreach( $rels as $item ) {
                 DB::table('enderecos')->where('id', '=', $item->id_endereco)
                    ->update($address);
            }
        }

        return $this->__response( $tdc, 'alterado com sucesso.' );

    }

    public function delete() 
    {

        $req  = $this->request;
        $tdc  = $req->input('form'); // tipo de conta
        $id   = $req->input('post.id');

        $where = array(
            array('id_conta', '=', $id),
            array('tipo_de_conta', '=', $tdc)
        );

        if($tdc == "instituicao") {
            $table = "instituicoes";
        }

        if($tdc == "outros") {
            $table = "clientes"; 
            $where[1][2] = 'cliente';
        }

        $find = DB::table('rel_conts_ends')->where($where)->get();

        if(count($find) != 0) {
            foreach ($find as $item) {
                
                # sql delete
                DB::table($table)->where('id', '=', $id)->delete();

                DB::table('enderecos')->where('id', '=', $item->id_endereco)->delete();
                DB::table('rel_conts_ends')->where('id', '=', $item->id)->delete();

            }
        }else{
            DB::table($table)->where('id', '=', $id)->delete();
        }

        return $this->__response( $tdc, 'excluido com sucesso.' );

    }


    public function __response( $tdc, $text ) 
    {
        $type = array(
            'instituicao' => 'Instituicão',
            'alunos' => 'Aluno',
            'outros' => 'Clientes',
        ); // tipo de formulario

        return array(
            'alert' => array(
                'title' => 'Sucesso!',
                'text' => $type[$tdc] .' '. $text,
                'outros' => 'Clientes',
                'type' => 'success'
            )
        );
    }

    public function __date_change( $date ) 
    {
        return implode('-', array_reverse(explode('/', $date)));
    }

    public function __get_all_instituicao() 
    {

        return DB::table('instituicoes')->get();

    }

  
    public function __get_instituicao_and_address() 
    {

        $table = DB::table('instituicoes');
            
        $query = $table->Leftjoin('rel_conts_ends as rel', function($join){
            $join->on('instituicoes.id', '=', 'rel.id_conta')->where('rel.tipo_de_conta', '=', 'instituicao');
        })->Leftjoin('enderecos as end', function($join) {
            $join->on('rel.id_endereco', '=', 'end.id');
        });

        $find = $query->select('instituicoes.*', 'end.logradouro', 'end.cep', 'end.complemento', 'end.numero', 'end.bairro', 'end.estado', 'end.cidade')
            ->get();

        return $find;

    }

    public function __get_alunos_and_address() 
    {

        $table = DB::table( "alunos" );

        $query = $table->Leftjoin('rel_conts_ends as rel', function($join) {
            $join->on('alunos.id', '=', 'rel.id_conta')->where('rel.tipo_de_conta', '=', 'alunos');
        })->Leftjoin('enderecos as end', function($join) {
            $join->on('rel.id_endereco', '=', 'end.id');
        });

        $find = $query->select('alunos.*', 'end.logradouro', 'end.cep', 'end.complemento', 'end.numero', 'end.bairro', 'end.estado', 'end.cidade')
            ->get();

        return $find;

    }

    public function __get_clientes_and_address() 
    {

        $table = DB::table('clientes');

        $query = $table->Leftjoin('rel_conts_ends as rel', function( $join ) {
            $join->on('clientes.id', '=', 'rel.id_conta')
                ->where('rel.tipo_de_conta', '=', 'cliente');
        })->Leftjoin('enderecos as end', function( $join ) {
            $join->on('rel.id_endereco', '=', 'end.id');
        });

        $find = $query->select(
            'clientes.*',
            'end.logradouro', 
            'end.cep', 
            'end.complemento', 
            'end.numero', 
            'end.bairro', 
            'end.estado', 
            'end.cidade'
        )->get();

        return $this->__filter_client($find);

    }

    public function __filter_client( $data ) 
    {

        $_list = array(); $_data = array();

        $_person = 'id,name,last_name,email,password,cpf,sexo,data_nascimento,telefone,celular,pin,termos,avatar';
        $_address = 'logradouro,cep,complemento,numero,bairro,estado,cidade';

        foreach( $data as $i => $item ) {
            if(array_key_exists($item->id, $_list)) {
                $_list[$item->id][] = $data[$i];
            }else{
                $_list[$item->id][] = $data[$i];
            }
        }

        $_list = array_values($_list);

        for( $j=0; $j<count($_list); $j++ ) {
            
            if( count($_list) > 1 ) {

                foreach ($_list[$j] as $i => $item) {
                    
                    foreach (explode(',', $_person) as $p => $person) {
                        $_data[$j][$person] = $item->{$person};
                    }

                    foreach (explode(',', $_address) as $a => $address) {
                        $_data[$j]['address'][$i][$address] = $item->{$address};
                    }

                }

            }

        }

        return $_data;

    }

}
