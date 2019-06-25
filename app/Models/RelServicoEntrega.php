<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class RelServicoEntrega extends Model
{

    protected $table = 'rel_servico_entrega';

    protected $fillable = [
        "produto_id",
        "modulo_id"
    ];

    static function CreateRels( $collection, $id )
    {
        
    	try {
    		foreach( $collection as $item ) {
    			self::create( [
    				'produto_id' => $id,
	    			'modulo_id' => $item
    			] );
	    	}
		}

		catch( QueryException $e ) {
			print_r($e->errorInfo);
		}

    }

    static function FindForIdProduct( $id ) 
    {

    	try {
			return self::where('produto_id', $id)
	    		->get()->toArray();
		}

		catch( QueryException $e ) {
			print_r($e->errorInfo);
		}

    }

    static function DeleteForIdProduct( $id ) 
    {

    	try {
			return self::where('produto_id', $id)->delete();
		}

		catch( QueryException $e ) {
			print_r($e->errorInfo);
		}
    		
    }


}
