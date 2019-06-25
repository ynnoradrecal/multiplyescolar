<?php

namespace App\Models;

use DB;

class Cart 
{
	public $quantidade;
	public $item = null;
	public $imagens = [];
	public $precoUnidadeImagem;
	public $valDesconto;
	public $maxImagesDesconto;
	public $cliente;
	public $precoTotal;
	public $politicas = [];


	public function __construct($oldCart)
	{
		if($oldCart){
			$this->imagens = $oldCart->imagens;
			$this->precoTotal = $oldCart->precoTotal;
			$this->precoUnidadeImagem = $oldCart->precoUnidadeImagem;
			$this->valDesconto =  $oldCart->valDesconto;
			$this->maxImagesDesconto = $oldCart->maxImagesDesconto;
			$this->cliente = $oldCart->cliente; 
		}
	}


	public function addCliente( $cliente )
	{
		$this->cliente = $cliente;
	}


	public function addImagens($imagens)
	{

		if( $this->imagens ){
			$contador = count($this->imagens);
			
			for($i = 0; $i< count($imagens); $i++){
				$this->imagens[$contador] = $imagens[$i];
				$contador++;
			}
		}else{
			$this->imagens = $imagens;
		}

	}


	// soma valor total das imagens seguindo as regras de preço
	public function genTotalValueImages( $id )
	{
		// recebe informações do produto
		$produto = DB::table('produtos')->find( $id );

		$baseQuantidade = 0;

		// valor unitário das fotos caso não existam politicas sobrescrevendo
		$baseSoma = $produto->foto_unit_val;

		// recebe imagens enviadas pelo cliente
		$totalImages = count( $this->imagens );
		
		// recebe regras para o cálculo, transformadas em array
		$regras = json_decode( $produto->regras, true );

		// dd( $regras );
		
		if( is_array($regras) ){

			for( $i =0; $i < count($regras); $i++ ){

				switch( $regras[$i]['condicao'] ){

					case '<=':
					
						if(	$regras[$i]['preco'] == 0.00 ) {
							
							$baseQuantidade = $regras[$i]['quantidade'];

						}else if( ($totalImages <= $regras[$i]['quantidade']) &&  $regras[$i]['preco'] > 0.00 ){
							
							$baseSoma = $regras[$i]['preco'];

						}else if( ($totalImages >= $regras[$i]['quantidade']) &&  $regras[$i]['preco'] > 0.00 ){
							
							$baseSoma = $produto->foto_unit_val;
						}

					break;

					case '>=':
						if(	$totalImages >= $regras[$i]['quantidade'] &&  $regras[$i]['preco'] > 0.00 ) {							
							$baseSoma = $regras[$i]['preco'];
						}
					break;

				}
			}

			// $baseSoma = (str_replace(',','.',$baseSoma));
			$baseSoma = number_format($baseSoma, 2, ',', '.');

			$this->precoUnidadeImagem = $baseSoma;

			// dd( $baseSoma . ' - '. $totalImages . ' - '. $baseQuantidade);
			// dd($this->precoTotal .' - '. $baseSoma . ' - '. $totalImages . ' - '. $baseQuantidade);
			// dd( $baseQuantidade );
			// 
			
			$this->valDesconto = 0.00;

			// if( $baseQuantidade >  $totalImages){
			// 	$this->valDesconto = ( $baseSoma * $totalImages);
			// }else{
			// 	$this->valDesconto = ( $baseSoma * $baseQuantidade);
			// }
			
			// em caso de preço negativo zera valor total
			if(($baseSoma * ($totalImages - $baseQuantidade)) < 0){
				$this->precoTotal = 0.00;
			}else{
				$this->precoTotal = $baseSoma * $totalImages;
				// $this->precoTotal = ($baseSoma * ($totalImages - $baseQuantidade));
			}

			$this->maxImagesDesconto = $baseQuantidade;

			return true;

		}

		$this->precoUnidadeImagem = $baseSoma;

		$this->precoTotal = ($baseSoma * $totalImages);

		return true;
	}



	public function addPoliticas( $politicas )
	{
		if( $this->politicas ){
			
			$contador = count($this->politicas);
			
			for($i = 0; $i< count($politicas); $i++){
				$this->politicas[$contador] = $politicas[$i];
				$contador++;
			}

		} else {
			$this->politicas = $politicas;
		}

		// incrementa valor dos adicionais(politicas)
		$this->precoTotal += $this->sumPoliticaPrice( $this->politicas );
	}


	// faz a soma dos opcionais
	protected function sumPoliticaPrice( $politicas )
	{
		$price = 0;

		for($i = 0; $i< count($politicas); $i++){
			$price += floatval($politicas[$i]["preco"]);
		}

		return $price;
	}


}
