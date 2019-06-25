<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminModuloNav extends Model
{
    protected $table = 'admin_modulo_nav';
    protected $fillable = [
        "id", 
        "tiutlo", 
        "tree"
    ];
}
