<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    protected $table = 'carrinho_abandonado';
    
    protected $fillable = [
        "cliente_id",
        "produto_id",
        "session_id",
        "session",
        "utils",
        "url",
        "status"
    ];

}
