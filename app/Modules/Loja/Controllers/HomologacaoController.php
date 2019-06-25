<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Session;

use App\Modules\Loja\Services\Cart;

class HomologacaoController extends Controller
{

	private $req;

    private $cart;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( Request $req ) 
    {


        $this->req = $req;
        $this->cart = new Cart( $req );

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $this->cart->__clean();

        $title = 'Galeria';
        $pageview = 'Loja::loggedin.homologacao';

        $data = DB::table('fotos_produto')->where('produto_id', 33)->paginate(12);

        return view($pageview, array(
            'title' => $title,
            'data' => $data
        ));

    }

    public function __cart() {
        
        	
        $mtds = $this->req->input('methods'); // methods

        if( empty($mtds) ) {

            $exists = $this->req->session()->has('carrinho'); // exists cart
            
            // verify exists cart
            if( !$exists ) {
                return $this->cart->__add( 'fotos' ); // add
            }else{
                return $this->cart->__up( $this->req, 'fotos' ); // update
            }

        }else{

            if( $mtds == 'show' ) {
                return $this->cart->__show();
            }

            if( $mtds == 'del' ) {
                return $this->cart->__del_item( 'fotos' );
            }

        }       

    }

    public function __comment() 
    {

        $cart = $this->req->session()->get('carrinho'); $key = 'fotos';
        $comment = $this->req->input('comments');

        $index = $this->exists_id( $comment['id'], $key );

        if( strlen($index) != 0 ) {
           
            $cart[$key][$index]['comment'] = $comment['comment'];

            $this->req->session()->put(array(
                'carrinho' => $cart
            ));

            return array(
                'status' => 'success',
                'action' => 'comment'
            );
        }

    }

    public function exists_id( $id, $key ) 
    {

        $cart = $this->req->session()->get('carrinho'); $index = '';

        foreach( $cart[$key] as $i => $item ) {
            if( $item['id'] == $id ) {
                $index = $i;
            }
        }

        return $index;

    }

    public function photos_validate() {

        $cart = $this->req->session()->get('carrinho'); $key = 'fotos';
        
        // $this->cart->__clean();
        
        $title = 'Fotos Selecionadas';
        $pageview = 'Loja::loggedin.photos-validate';
        
        // dd($cart);

        return view($pageview, array(
            'title' => $title,
            'data' => $cart[$key]
        ));

    }

}