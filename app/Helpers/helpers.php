<?php
/**
* change plain number to formatted currency
*
* @param $number
* @param $currency
*/
function formatNumber($number, $currency = 'R$')
{
   if($currency == 'R$') {
        return number_format($number, 2, ',', '.');
   }
   return number_format($number, 0, ',', '.');
}


// retorna bandeira do cartão
function bandeira($code)
{
    $array = [
        '101' => 'Cartão de crédito Visa.',
        '102' => 'Cartão de crédito MasterCard.',
        '103' => 'Cartão de crédito American Express.',
        '104' => 'Cartão de crédito Diners.',
        '105' => 'Cartão de crédito Hipercard.',
        '106' => 'Cartão de crédito Aura.',
        '107' => 'Cartão de crédito Elo.',
        '108' => 'Cartão de crédito PLENOCard. *',
        '109' => 'Cartão de crédito PersonalCard.',
        '110' => 'Cartão de crédito JCB. *',
        '111' => 'Cartão de crédito Discover. *',
        '112' => 'Cartão de crédito BrasilCard.',
        '113' => 'Cartão de crédito FORTBRASIL.',
        '114' => 'Cartão de crédito CARDBAN. *',
        '115' => 'Cartão de crédito VALECARD.',
        '116' => 'Cartão de crédito Cabal.',
        '117' => 'Cartão de crédito Mais!.',
        '118' => 'Cartão de crédito Avista. *',
        '119' => 'Cartão de crédito GRANDCARD.',
        '120' => 'Cartão de crédito Sorocred',
        '122' => 'Cartão de crédito Up Policard',
        '123' => 'Cartão de crédito Banese Card',
        '201' => 'Boleto Bradesco. *',
        '202' => 'Boleto Santander.',
        '301' => 'Débito online Bradesco.',
        '302' => 'Débito online Itaú',
        '303' => 'Débito online Unibanco. *',
        '304' => 'Débito online Banco do Brasil.',
        '305' => 'Débito online Banco Real. *',
        '306' => 'Débito online Banrisul.',
        '307' => 'Débito online HSBC.',
        '401' => 'Saldo PagSeguro.',
        '501' => 'Oi Paggo. *',
        '701' => 'Depósito em conta - Banco do Brasil'			
    ];

    foreach( $array as $key => $val) {
        if($key == $code){
            return $val;
        }
    }

    return 'Bandeira não informada';
}


// retorna status pagamento
function statusPagamento($code)
{
    $array = [
        '1' => 'Aguardando pagamento',
        '2' => 'Em análise',
        '3' => 'Paga',
        '4' => 'Disponível',
        '5' => 'Em disputa',
        '6' => 'Devolvida',
        '7' => 'Cancelada',
        '8' => 'Debitado',
        '9' => 'Retenção temporária'
    ];

    foreach( $array as $key => $val){
        if($key == $code){
            return $val;
        }
    }

    return 'Status inexistente';
}