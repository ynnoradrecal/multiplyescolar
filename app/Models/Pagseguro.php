<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagseguro extends Model
{
    protected $table = 'admin_modulo_pagseguro';
    protected $fillable = [
        "token",
        "email",
        "url_redirect"
    ];

}
