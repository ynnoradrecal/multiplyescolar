<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Endereco;
use Validator;
use DB;
use Auth;

class PedidosController extends Controller
{	
	
	// lista pedidos
	public function listPedidos( $cliente_id )
	{
		$pedidos = DB::table("pedidos")->where([
			['pedidos.cliente_id', '=', $cliente_id]
		])
		->orderBy('id', 'desc')
		->get();
		
		return view( 'Loja::loggedin.lista-pedidos', compact("pedidos"));
	}

	/// mostra pedido por cliente e id do pedido_id
	public function showPedido( $cliente_id, $pedido_id, $ref )
	{
		$pedido = DB::table('clientes')
			->where('clientes.id', '=', $cliente_id )
			->join('pedidos', 'pedidos.cliente_id', '=', 'clientes.id')
			->where('pedidos.id', '=', $pedido_id)
			->join('itens_pedidos as itens', 'itens.pedido_id', '=', 'pedidos.id')
			->join('enderecos as end', 'end.id', '=', 'pedidos.endereco_id')
			->leftJoin('fotos_produto', 'fotos_produto.id', '=', 'itens.item_id')
			->get();

		// dd( $pedido );

		// caso exista algum dado errado
		if( count($pedido) == 0){
			return redirect()
					->back()
						->with(['referencia' =>  $ref]);
		}


		for($i =0; $i < count($pedido); $i++){
			if($pedido[$i]->titulo == 'Foto'){
				$fotos[] = DB::table('fotos_produto')->where('id',$pedido[$i]->item_id)->first();
			}
		}


		// dd( $fotos );

		return view( 'Loja::loggedin.detalhe-pedido', compact('pedido', 'fotos'));

	}


}