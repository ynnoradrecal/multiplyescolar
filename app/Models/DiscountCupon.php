<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCupon extends Model
{
    //
    protected $fillable = [
         'name',
         'code',
         'date_validate',
         'limit_for_use',
         'type',
         'value',
         'status',
         'descricao'
    ];
}
