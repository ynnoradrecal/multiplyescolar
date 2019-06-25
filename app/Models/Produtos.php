<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

use Response;

class Produtos extends Model
{

    protected $table = 'produtos';

    protected $fillable = [
        "event_id",
        "aluno_id",
        "instituicao_id",
        "nome",
        'thumb_small',
        "pin",
        "foto_unit_val",
        "regras",
        "status",
        "descricao"
    ];

    static $lastId = '';

    static function GetId( $id )
    {
        self::$lastId = $id;
    }

    static function SetId()
    { 
        
        return self::$lastId;
    }

    static function CreateOrUpdateProduct( $collection, $id )
    {
        
        try {
            
            // insert 
            if( empty($id) ) {
                self::GetId(self::create($collection)->id);  
            }

            // upadte 
            else{
                return self::where('id', $id)->update( $collection );
            }
        }

        catch( QueryException $e ) {

            return Response::json([
                'alert' => [
                    'title' => 'Falhou!',
                    'text'  => 'Error: '. implode(' ', $e->errorInfo),
                    'type'  => 'fail'
                ]
            ],422);

        }

    }

    static function UpdateStatusInstituicao( $id ) 
    {
        self::where('id', $id)->update(['instituicao_id'=>0]);
    }

}
