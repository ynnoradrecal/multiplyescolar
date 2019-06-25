<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{

    protected $table = "admin_usuarios";
    protected $fillable = [
        "id", 
        "nome", 
        "email",
        "password",
        "foto",
        "descricao",
        "remember_token",
        "id_grupo",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}