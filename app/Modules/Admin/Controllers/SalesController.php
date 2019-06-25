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

    public $req;

    public $galeria; // Nome da Galeria

    public function __construct( Request $req )  
    {
        
        $this->req = $req;
    
    }

    public function init() 
    {

        $auth = Auth::guard('admin_user')->user();
        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);


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
        
        $status = 0;

        if( $this->req->input('status') != 0 ) {
            $status = $this->req->input('status');
        }

        $table = DB::table( 'pedidos' );

        $query = $table->Leftjoin('clientes as cli', function($join) {
            $join->on('pedidos.cliente_id', '=', 'cli.id');
        })->where('pedidos.status_pedido', '=', $status);

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
            'pedidos.metodo_frete',
            'pedidos.valor_frete',
            'pedidos.desconto',
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
        $find[0]->galeria = $this->galeria;

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

        $find = $query->select('itens_pedidos.item_id', 'itens_pedidos.titulo', 'itens_pedidos.descricao', 'itens_pedidos.valor_unitario', 'pds.nome')->get();

        $this->galeria = $find[0]->nome;

        foreach($find as $item) {
            
            if($item->titulo == 'Foto') {

                $foto = $this->__get_photo_for_id( $item->item_id, $item->valor_unitario, $item->descricao );

                if(count($foto) != 0) {
                    $data['fotos'][] = $foto;
                }

            }else{

                $explode = explode(':', $item->titulo);

                $data['opcoes'][] = array(

                    'name'  => trim($explode[1]),
                    'preco' => $item->valor_unitario

                );

            }

        }
        
        return $data;

    }

    protected function __get_photo_for_id( $id, $preco, $descricao ) {
        
        $table = DB::table( 'fotos_produto' )->where('id', '=', $id);

        $find  = $table->get();

        if(count($find) != 0) {
            return array(
                'name' => $find[0]->name,
                'url'  => $find[0]->url,
                'preco' => $preco,
                'descricao' => $descricao
            );
        }

    }

    public function __post_notice() 
    {

        $post = $this->req->input('post');

        $table = DB::table('pedido_notificacao')->insert(
            array(
                'id_pedido' => $post['id_pedido'],
                'pagamento' => $post['pagamento'],
                'entrega' => $post['entrega'],
                'comentario' => $post['comentario']
            )
        );

        return response()->json(array(
            "status"=>"success",
        ), 200);

    }

    public function __get_notice_for_id() 
    {

        $table = DB::table('pedido_notificacao');
        $query = $table->where('id_pedido', '=', $this->req->input('id'));

        return $query->get();

    }

    public function __pedido_concluido() 
    {

        $post = $this->req->input('post');

        $table = DB::table('pedidos');
        $query = $table->where('id', '=', $post['id'])
            ->update(array('status_pedido' => $post['status']));

        return response()->json(array(
            "status"=>"success",
        ), 200);

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

    public function __delete_order() 
    {

        $post = $this->req->all();

        $t_order = DB::table('pedidos'); // table order
        $t_itens = DB::table('itens_pedidos'); // table itens order

        $f_order = $t_order->where('id', '=', $post['id'])->first(); // find order

        $t_itens->where('pedido_id', '=', $f_order->id)->delete();
        $t_order->where('id', '=', $post['id'])->delete();

        return array(
            'status' => 'success'
        );

    }



}
