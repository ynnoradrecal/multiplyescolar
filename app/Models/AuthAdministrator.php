<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthAdministrator extends Model
{
    protected $table = "auth_administrator";
    protected $fillable = [
        "id", 
        "nome", 
        "login",
        "senha"
    ];
}
