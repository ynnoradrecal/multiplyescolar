<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Auth;

class CorreiosController extends Controller
{


	public function init()
	{
		$dados = [
			'tipo'              => 'sedex', // opções: `sedex`, `sedex_a_cobrar`, `sedex_10`, `sedex_hoje`, `pac`, 'pac_contrato', 'sedex_contrato' , 'esedex'
			'formato'           => 'caixa', // opções: `caixa`, `rolo`, `envelope`
			'cep_destino'       => '89062086', // Obrigatório
			'cep_origem'        => '89062080', // Obrigatorio
			//'empresa'         => '', // Código da empresa junto aos correios, não obrigatório.
			//'senha'           => '', // Senha da empresa junto aos correios, não obrigatório.
			'peso'              => '1', // Peso em kilos
			'comprimento'       => '16', // Em centímetros
			'altura'            => '11', // Em centímetros
			'largura'           => '11', // Em centímetros
			'diametro'          => '0', // Em centímetros, no caso de rolo
			// 'mao_propria'       => '1', // Não obrigatórios
			// 'valor_declarado'   => '1', // Não obrigatórios
			// 'aviso_recebimento' => '1', // Não obrigatórios
		];

		echo Correios::frete($dados);
		
		/*
			Retorno:
			Array
			(
				[codigo] => 40010
				[valor] => 14.9
				[prazo] => 1
				[mao_propria] => 0
				[aviso_recebimento] => 0
				[valor_declarado] => 0
				[entrega_domiciliar] => 1
				[entrega_sabado] => 1
				[erro] => Array
					(
						[codigo] => 0
						[mensagem] => 
					)

			)
		*/
	}
}