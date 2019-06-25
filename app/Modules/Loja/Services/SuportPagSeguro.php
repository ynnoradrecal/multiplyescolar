<?php

namespace App\Modules\Loja\Services;

use Illuminate\Http\Request;

class SuportPagSeguro
{

    public static $m_InstallmentsPagSeguro = [
        1 => 1.02982,
        2 => 0.52255,
        3 => 0.35347,
        4 => 0.26898,
        5 => 0.21830,
        6 => 0.18453,
        7 => 0.16044,
        8 => 0.14240,
        9 => 0.12838,
        10 => 0.11717,
        11 => 0.10802,
        12 => 0.10040,
        13 => 0.09397,
        14 => 0.08846,
        15 => 0.08371,
        16 => 0.07955,
        17 => 0.07589,
        18 => 0.07265
    ];

    public static function calcInstallments($v_MaxInstallmentsNoInterest, $p_Value, $p_Installments)
    {
        if($p_Installments <= $v_MaxInstallmentsNoInterest)
            $v_InstallmentValue = $p_Value/$p_Installments;
        else
        {
            $v_InstallmentValue = $p_Value*(self::$m_InstallmentsPagSeguro[$p_Installments - $v_MaxInstallmentsNoInterest]);
            $v_InstallmentValue = number_format(round($v_InstallmentValue*($p_Installments - $v_MaxInstallmentsNoInterest), 2), 2, '.', '');
            $v_InstallmentValue = $v_InstallmentValue/$p_Installments;
        }

        return number_format(round($v_InstallmentValue, 2), 2, '.', '');
    }

}