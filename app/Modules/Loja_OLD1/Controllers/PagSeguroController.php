<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Correios;
use URL;
use Auth;
use App\Models\Cart;
use App\Models\Pedido;
use App\Models\Endereco;
use App\Models\AbandonedCart;
use Carbon\Carbon;
use PagSeguro;

class PagSeguroController extends Controller{

	public function init(Request $request)
	{
		
		// get notification return
		$xml = PagSeguro::notification($request->notificationCode, $request->notificationType);

		// atualiza o pedido com os dados de retorno do pagseguro
		Pedido::where('referencia', $xml->reference)->update(['status' => $xml->status]);

		return true;
	}



}