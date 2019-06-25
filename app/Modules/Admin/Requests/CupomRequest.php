<?php

namespace App\Modules\Admin\Requests;

use Validator;
use Illuminate\Http\Request;

class CupomRequest
{

    public $authorize;

    public function __construct( $req ) 
    {

        $this->authorize = Validator::make($req->all(), 
            $this->rules(), $this->message()
        );

    }

    public function rules()
    {
        return array(
            'post.name' => 'required',
            'post.code' => 'required',
            'post.value' => 'required',
        );
    }

    public function message() 
    {

        return array(
            'post.name.required' => 'O campo "Nome" é obrigatório!',
            'post.code.required' => 'O campo "Codigo" é obrigatório!',
            'post.value.required' => 'O campo "Valor do Desconto" é obrigatório!',
        );

    }

    public function is_not_success()
    {

        $res = false;

        if( $this->authorize->fails() ) {

            $res = response()->json(array(
                $this->authorize->errors()
            ), 422);  

        }

        return $res;

    }

}
