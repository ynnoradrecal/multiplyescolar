<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItensPedido extends Model
{
	protected $table = 'itens_pedidos';
	protected $fillable = [
		'pedido_id',
		'produto_id',
		'item_id',
		'titulo',
		'quantidade',
		'valor_unitario',
		'descricao'
	];

	// public function pedidos(){
	// 	return $this->belongsTo('App\Models\Pedido','pedido_id','id');
	// }
	

}