<?php

namespace App\Modules\Loja\Services;

use Illuminate\Http\Request;

use Session;
use PagSeguro;
use PagSeguroClient;
use Response;

class SPagSeguro
{

	private $ref;

	private $pag;

	private $info = [
		'senderName'  => '', //'Nome Completo', //Deve conter nome e sobrenome
	    'senderPhone' => '', //'(32) 1324-1421', //Código de área enviado junto com o telefone
	    'senderEmail' => '', //'email@email.com',
	    'senderHash'  => '', //'Hash gerado pelo javascript',
	    'senderCPF'   => ''  //'123.456.789-00' //Ou CNPJ se for Pessoa Júridica
	];

	private $credit_card = [
		'creditCardHolderName'      => '', //'Nome Completo', //Deve conter nome e sobrenome
		'creditCardHolderPhone'     => '', //'(32) 1324-1421', //Código de área enviado junto com o telefone
		'creditCardHolderCPF'       => '', //'123.456.789-00', //Ou CNPJ se for Pessoa Júridica
		'creditCardHolderBirthDate' => ''  //'10/02/2000',
	];

	private $shipping = [
		'shippingAddressStreet'     => '', // 'Rua/Avenida',
		'shippingAddressNumber'     => '', //'Número',
		'shippingAddressDistrict'   => '', //'Bairro',
		'shippingAddressPostalCode' => '', //'12345-678',
		'shippingAddressCity'       => '', //'Cidade'
		'shippingAddressState'      => ''  // Estado
	];

	private $billing = [
		'billingAddressStreet' 	   => '', //' ua/Avenida'
		'billingAddressNumber' 	   => '', //' úmero'
		'billingAddressDistrict'   => '', //' airro'
		'billingAddressPostalCode' => '', //' 2345-678'
		'billingAddressCity' 	   => '', // Cidade'
		'billingAddressState' 	   => ''  // Estado 
	];

	private $items = [];

	public $error;

	public $is_success;

	public function __construct( Array $args ) 
	{

		extract( $args );

		$this->ref = $referencia;

		$this->setInfo( $info );

		if( $credit['status'] ) {
			$this->setCreditCard($credit['card']);
		}

		if( $debito['status'] ) {
			//...
		}

		if( $boleto['status'] ) {
			// ...
		}
		
		$this->setAddress( $address['data'], $address['billing'] );

		$this->itemsProducts($items['images'], $items['adicionais'], $items['photo_value'], $items['gallery']);

		$this->setCreditPay([
			'payment'=>'creditCard', 
			'token'=>$token, 
			'quantity'=>$quantity, 
			'value'=>$value, 
			'interest_free'=>$interest_free,
			'desconto' => $desconto
		]);


	}

	private function setInfo( Array $items )
	{

		$n = 0;
		
		if( $this->validate( $items ) != 0 ){
			$this->error = 'Dados do cliente não foram todos preechidos!';
		}

		else{

			foreach( array_keys($this->info) as $i ){
				$this->info[$i] = $items[$n]; $n++;
			}

			return true;

		}

		return false;

	}

	private function setCreditCard( Array $items ) 
	{

		$n = 0;

		if( $this->validate( $items ) != 0 ) {
			$this->error = 'Dados do Cartão não estão preenchidos!';
		}

		else{

			foreach( array_keys($this->credit_card) as $i ){
				$this->credit_card[$i] = $items[$n]; $n++;
			}

			return true;

		}

		return false;

	}

	private function setAddress( $address, $billing ) 
	{
		
		unset($address[5]);

		if( $this->validate( $address ) != 0 ) {
			$this->error = 'Necessário de um endereço valido para cobrança!';
		}

		else{

			$s = 0; $b = 0;

			$address = array_values($address);

			if( $billing ) {
				foreach( array_keys($this->billing) as $i ){
					$this->billing[$i] = $address[$b]; $b++;
				}
			}

			foreach( array_keys($this->shipping) as $i ){
				$this->shipping[$i] = $address[$s]; $s++;
			}

			return true;

		}
	
		return false;

	}

	private function itemsProducts( $images, $adicionais, $price, $gallery ) 
	{


		foreach( $images as $image ) {
			$this->items[] = [
				'itemId' => $image['id'],
		    	'itemDescription' => $image['id'] .' - '. $gallery,
		    	'itemAmount' => $price,
		    	'itemQuantity' => '1',
			];
		}

		if( count($adicionais) ) {
			foreach( $adicionais as $adi ) {

				if( floatval($adi['preco']) > 0 ) {
					$this->items[] = [
						'itemId' => $adi['politica_id'],
				    	'itemDescription' => $adi['politica_id'] .' - '. $adi['titulo'],
				    	'itemAmount' => floatval($adi['preco']),
				    	'itemQuantity' => '1',
					];
				}

			}
		}

		return true;

	}

	private function setCreditPay( $args )
	{

		extract($args);
		
		try {

			$pagseguro = PagSeguro::setReference($this->ref);

			$pagseguro->setSenderInfo($this->info);
			$pagseguro->setCreditCardHolder($this->credit_card);
			$pagseguro->setShippingAddress($this->shipping);
			$pagseguro->setBillingAddress($this->billing);
			$pagseguro->setItems($this->items);

			if( $desconto != 0 ) {
				$pagseguro->setExtraAmount( - $desconto );
			}

			$result = $pagseguro->send([

				'paymentMethod'       => $payment,
				'creditCardToken'     => $token,
				'installmentQuantity' => $quantity,
				'installmentValue'    => $value,
				'noInterestInstallmentQuantity' => $interest_free

			]);	

		} catch (\Artistas\PagSeguro\PagSeguroException $e) {
			$this->error = json_encode([
				'error' => [
					'code'    => $e->getCode(), 
					'message' => $e->getMessage()
				]
			]);
		}

		$this->is_success = json_encode($result);

	}

	public function validate( $items ) 
	{

		$count = 0;
		
		foreach( $items as $item ) {
			if( empty($item) )
				$count = $count + 1;
		}

		return $count;

	}

}