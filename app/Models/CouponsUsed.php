<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponsUsed extends Model
{
    
    protected $fillable = [
        "id_cliente",
        "id_cupom",
    ];

}