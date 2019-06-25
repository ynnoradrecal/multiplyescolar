<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modules\Admin\Services\CustomHelpers;

class DashboardController extends Controller
{

    public $req;

    protected $view = "Admin::sections";

    public function __construct( Request $req )  
    {
        
        $this->req = $req;

    }

    public function init()
    {

    	if( !Auth::guard('admin_user')->check() ) {
            return redirect('/admin');
        }

        $auth = Auth::guard('admin_user')->user();

        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);
        
        if( empty($this->req->input( "methods" )) ) {

            return view( $this->view .".dashboard", array(
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

    private function __get_sales() {

        $parcial = 0;

        $table = DB::table('pedidos');

        $query = $table->where('status_pedido', '=', 1);
        $data = $query->select('id', 'total_parcial')->get();

        foreach( $data as $item ) {
            $parcial = ($parcial + $item->total_parcial);
        }

        return $parcial;

    }

    private function __get_client() {

        $table = DB::table('clientes');

        $clients = $table->get();

        return count($clients);

    }

    private function __get_orders() {

        $table = DB::table('pedidos');

        $query = $table->Leftjoin('clientes as cli', function($join) {
            $join->on('pedidos.cliente_id', '=', 'cli.id');
        })->where('pedidos.status_pedido', '=', 0);

        $orders = $query->select('pedidos.id', 'pedidos.num_pedido', 'cli.name', 'pedidos.valor_pedido', 'pedidos.status')->get();

        return array(
            'tt' => count($orders),
            'orders' => $orders
        );

    }


}
