<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use DB;
use Input;
use Auth;

use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;

class SalesController extends Controller
{

    protected $view = "Admin::sections";

    public function __construct( Request $req )  
    {
        
        $this->req = $req;
    
    }

    public function init() 
    {

        $auth = Auth::guard('admin_user')->user();
        $auth->foto = CustomHelpers::__get_before_photo_user($auth->foto);


        if( empty($this->req->input( "methods" )) ) {

            return view( $this->view .".order", array(
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

    public function __get_order()
    {
        
        $table = DB::table( 'pedidos' );

        $query = $table->Leftjoin('clientes as cli', function($join) {
            $join->on('pedidos.cliente_id', '=', 'cli.id');
        });

        $find = $query->select('pedidos.id', 'pedidos.num_pedido', 'pedidos.code_transacao', 'pedidos.created_at', 'cli.name', 'pedidos.valor_pedido', 'pedidos.status');

        return $find->get();

    }

    public function __get_order_for_id() 
    {
        
        $table = DB::table( 'pedidos' )->where('pedidos.id', $this->req->input('id'));

        $query = $table->Leftjoin('clientes as cli', function($join) {
                    $join->on('pedidos.cliente_id', '=', 'cli.id');
                })->Leftjoin('enderecos as end', function($join) {
                    $join->on('pedidos.endereco_id', '=', 'end.id');
                });

        $find = $query->select(
            'pedidos.id',
            'pedidos.num_pedido',
            'pedidos.code_transacao',
            'pedidos.created_at',
            'pedidos.valor_pedido',
            'pedidos.status',
            'cli.name',
            'cli.email',
            'cli.telefone',
            'cli.data_nascimento',
            'end.cep',
            'end.logradouro',
            'end.numero',
            'end.estado',
            'end.cidade'
        )->get();

        $find[0]->itens = $this->__get_itens( $this->req->input('id') );

        return $find;

    }

    public function __get_itens( $id ) 
    {

        $data = array(); $preco_foto = 0;

        $tt = 0; // total de fotos

        $table = DB::table( 'itens_pedidos' )->where('itens_pedidos.pedido_id', $this->req->input('id'));

        $query = $table->Leftjoin('produtos as pds', function($join) {
            $join->on('itens_pedidos.produto_id', '=', 'pds.id');
        });

        $find = $query->select('itens_pedidos.titulo', 'itens_pedidos.descricao', 'itens_pedidos.valor_unitario', 'pds.nome')->get();

        foreach( $find as $item ) {

            if(empty($item->descricao)) {
                
                $tt++;

                $preco_foto = $item->valor_unitario;

            }else{

                $frg = explode(':', $item->titulo);

                $data['desc'][] = array(
                    'titulo' => $frg[0],
                    'value' => $frg[1],
                    'preco' => $item->valor_unitario
                );

            }

            if(!empty($item->nome)){

                $data['nome_produto'] = $item->nome;

            }

        }

        $data['desc'][] = array(
            'titulo' => 'Fotos',
            'value' => $tt,
            'preco' => $preco_foto * $tt
        );

        return $data;

    }

    public function order_view(Request $req)
    {
        return view($this->view, $this->get_data( $req ));
    }

    public function aband_cart(Request $req)
    {
        return view($this->view, $this->get_data( $req ));
    }

    public function get_data( $req ) 
    {
        return array(
            "login"=> 1,
            "param"=> @array_pop(explode("/", $req->path()))
        );
    }



}
