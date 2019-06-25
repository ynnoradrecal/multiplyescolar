<?php

namespace App\Modules\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class GaleriaRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'post.nome' => 'required',
            'post.event_id' => 'required',
            'post.foto_unit_val' => 'required'
        ];
       
        if( $this->input('post.instituicao_id') == 0 ) {
            $rules['post.delivery'] = 'required';
        }

        else{
             $rules['post.instituicao_id'] = 'required';
        }

        return $rules;

    }

    public function messages()
    {

        $message = [
            'post.nome.required' => 'O campo "Nome" é obrigatório.',
            'post.event_id.required' => 'O campo "Evento" é obrigatório.',
            'post.foto_unit_val.required' => 'O campo "Preço da Foto" é obrigatório.'
        ];

        if( $this->input('post.instituicao_id') == 0 ) {
            $message['post.delivery.required'] = 'O campo "Serviço de Entrega" é obrigatório.';
        }

        return $message;
    }

}
