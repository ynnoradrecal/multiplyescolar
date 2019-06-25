<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Loja\Helpers\EmailHelper;
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
		
		$pedidos = $this->getOrderDataTo( $xml->reference );

		// return $pedidos[0]->status;
		
		if( $pedidos[0]->status == 3){
			$this->sendOrderPaymentConfirmationEmail( $pedidos );
			// $this->sendOrderPaymentConfirmationAdminEmail( $pedidos );
		}

		if( $pedidos[0]->status == 7){
			$this->sendOrderCancelledEmail( $pedidos );
			$this->sendOrderCancelledAdminEmail( $pedidos );
		}



		return 'Deu certo';
	}



	public function getOrderDataTo($ref)
	{
		$pedidos = DB::table('pedidos as p')
					->where('p.referencia', '=', $ref)
					->leftJoin('itens_pedidos as ip', 'ip.pedido_id', '=', 'p.id')
					->leftJoin('enderecos as end', 'end.id', '=', 'p.endereco_id')
					->leftJoin('produtos as prod', 'prod.id', '=', 'ip.produto_id')
					->leftJoin('events', 'events.id', '=', 'prod.event_id')
					->leftJoin('clientes as cli','cli.id','=','p.cliente_id')
					->select('prod.nome as prod_nome', 'events.name as event_name', 'end.*', 'ip.*', 'p.*','cli.name as nome_cliente','cli.last_name as sobrenome_cliente', 'cli.email as email')
					->get();

		return $pedidos;
	}



	/*
	*	Envia confirmação de compra para o cliente
	*/ 
	public function sendOrderPaymentConfirmationEmail($pedidos)
	{		
		// $to = 'atendimento@multiply.art.br';  
		$to = $pedidos[0]->email; 
		$email = new EmailHelper();
		$email->sendPaymentConfirmationEmail( $to, $pedidos );
		return $pedidos;
	}



	/*
	*	Envia Cancelamento de compra para o cliente 
	*/
	public function sendOrderCancelledEmail($pedidos)
	{
		
		// $to = 'atendimento@multiply.art.br';  
		$to = $pedidos[0]->email; 
		$email = new EmailHelper();
		$email->sendPaymentCancelledEmail( $to, $pedidos );
		return $pedidos;
	}



	/*
	*	Envia Cancelamento de compra para o Administrador
	*/
	public function sendOrderCancelledAdminEmail($pedidos)
	{
		
		$to = 'atendimento@multiply.art.br';
		$email = new EmailHelper();
		$email->sendPaymentCancelledEmail( $to, $pedidos );
		return $pedidos;
	}



	/*
	*	Envia confirmação de pagamento para o administrador
	*/
	public function sendOrderPaymentConfirmationAdminEmail($pedidos)
	{		
		$to = 'atendimento@multiply.art.br';  
		$email = new EmailHelper();
		$email->sendPaymentConfirmationEmail( $to, $pedidos );
		return $pedidos;
	}



}