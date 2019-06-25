<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItensPedido;

class Pedido extends Model
{
	
	protected $fillable = [
		'cliente_id',
		'endereco_id',
		'num_pedido',
		'code_transacao',
		'referencia',
		'valor_pedido',
		'total_parcial',
		'prazo_entrega',
		'tipo_pagamento',
		'metodo_frete',
		'valor_frete',
		'desconto',
		'status'
	];

	public function itens() {
        return $this->hasMany(ItensPedido::class, 'pedido_id', 'id');
	}
	

}
