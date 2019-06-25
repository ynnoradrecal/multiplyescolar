<?php
namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PedidosController extends Controller
{
  
	public function index()
	{
		$pedido = Pedido::all();
		return $pedido;
	}

	public function show(Request $resquest, $id)
	{
		$pedido = Pedido::with('itens')->find($id);
		return $pedido;
	}

	public function update(Request $request, $id)
	{

		 $validator = Validator::make($request->all(), [
			'id' => 'required',
			'cliente_id' => 'required',
			'endereco_id' => 'required',
			'num_pedido' => 'required'
		]);

		$pedido = Pedido::with('itens')->find($id);
		$pedido->num_pedido = $request->input('num_pedido');
		$pedido->save();

		$getPed = Pedido::with('itens')->find($id);
		dd($getPed);
	}

}
