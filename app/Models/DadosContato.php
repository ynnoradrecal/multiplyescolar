<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DadosContato extends Model
{
    // tabela mãe das configurações
    protected $table = 'admin_modulo_contato';
    protected $fillable = [
       
    ];

    // public function getAllModulos($tipo, $slug)
    // {
    //     $slugs =  DB::table('admin_modulos')->where('tipo', '=' , $tipo)->pluck('slug');

	// 	$inner = '';

	// 	foreach($slugs as $slug){
	// 		$inner .= 'INNER JOIN admin_modulo_'. $slug .' AS am_' . $slug . ' ON admin_modulos.id = am_' . $slug . '.modulo_id';
	// 	}

	// 	$select = 'SELECT * 
	// 				FROM admin_modulos 
	// 				'. $inner .'
	// 				WHERE
	// 				tipo = '. $tipo ;
		
	// 	$teste = DB::select($select);
    // }

}
