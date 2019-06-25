<?php

namespace App\Modules\Beta\Services;

use Illuminate\Http\Request;

use Session;

class Cart
{

	public $req;

    private $cart = 'scart';

	public function __construct( $request ) 
	{
		$this->req = $request;
	}

    public function __show() 
    {

    	$exists = $this->req->session()->has($this->cart); // exists cart
    	$cart   = $this->req->session()->get($this->cart);
       
    	if( $exists ) {

    		return response()->json([
    			'status' => 'success',
    			'action' => 'show', // up, show, upd, del
    			'data'   => array(
                    'fotos' => $cart['imagens']
                ),
    		]);

    	}

    	return response()->json([
			'status' => 'failed',
    		'message' => 'Nenhum valor declarado no carrinho!'
		]);

    }

    public function __add( $key ) 
    {
        
		$this->req->session()->put(array(
			$this->cart => array(
				'imagens' => $this->req->input($key)
			)
		));

		return array(
    		'status' => 'success',
    		'action' => 'add', // add, show, up, del
    	    $this->cart => $this->req->session()->get($this->cart)
        );

    }


    public function __up( $req, $key ) 
    {

    	$data = $req->input($key);

    	if( $this->req->session()->has($this->cart) && count($data) != 0 ) {

			$cart = $this->req->session()->get($this->cart);
			
    		$cart['imagens'][] = last($data);

    		$this->req->session()->put(array(
    			$this->cart => $cart
    		));

    		return array(
    			'status' => 'success',
    			'action' => 'up', // up, show, upd, del
    		    $this->cart => $this->req->session()->get($this->cart)
            );

		}

    }

    public function __clean() {

    	$this->req->session()->flush();

    }

    public function __del_item( $key ) 
    {

    	$id = $this->req->input('id'); $cart = Session::get($this->cart);

        foreach( $cart['imagens'] as $i => $item ) {
            if( $item['id'] == $id ) {
                unset($cart['imagens'][$i]);
            }
        }

        $this->req->session()->put(array(
            $this->cart => $cart
        ));

        return array(
            'status' => 'success',
            'action' => 'del', // up, show, upd, del
            $this->cart => $this->req->session()->get($this->cart) 
        );

    }

    public function exists_id( $id, $key )
    {

        $cart = Session::get($this->cart); $index = '';
        
        foreach( $cart[$key] as $i => $item ) {
            if( $item['id'] == $id ) {
                $index = $i;
            }
        }
       
        return $index;

    }

    static function info_cart( $product ) 
    {

        $nucleo = Session::get('nucleo');
        $scart  = Session::get('scart');

        $event   = (object) $nucleo['event'];
        $policys = $nucleo['policys'];

        $info = [
            [
                'descricao' => 'Fotos / '. $event->gallery,
                'quantidade' => count($scart['imagens']),
                'valor_da_unidade' => $product->foto_unit_val,
                'subtotal' => floatval($product->foto_unit_val) * count($scart['imagens'])
            ]
        ];

        foreach( $policys as $item ) {
            $info[] = [
                'descricao' => $item['titulo'],
                'quantidade' => 1,
                'valor_da_unidade' => floatval($item['preco']),
                'subtotal' => floatval($item['preco'])
            ];
        }

        return $info;

    }

}
