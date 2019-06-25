<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminGrupo extends Model
{
    protected $table = "admin_grupo";
    protected $fillable = [
        "id", 
        "nome", 
        "descricao",
        "nivel"
    ];
}
