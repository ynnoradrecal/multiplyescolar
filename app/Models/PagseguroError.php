<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagseguroError extends Model
{
    protected $fillable = [
        "client_id",
        "code",
        "message"
    ];

}