<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Politica extends Model
{

    protected $table = 'politicas';

    protected $fillable = [
        "nome", 
        "slug", 
        "tipo",
        "quantidade",
        "campos",
        "descricao",
        "list"
    ];
    
}
