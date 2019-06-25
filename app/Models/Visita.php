<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
	//protected $table = 'admin_modulo_pagseguro';
	protected $fillable = [
		'ip','dispositivo','navegador','sistema','pagina', 'contador'
	];

}
