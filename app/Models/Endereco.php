<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';
    protected $fillable = [
        "logradouro", 
        "cep", 
        "numero", 
        "complemento", 
        "bairro", 
        "estado", 
        "cidade",
        "entrega"
    ];
}
