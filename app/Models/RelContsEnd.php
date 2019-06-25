<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelContsEnd extends Model
{

    protected $table = 'rel_conts_ends';
    protected $fillable = [
        "id_conta",
        "tipo_de_conta",
        "id_endereco"
    ];

}
