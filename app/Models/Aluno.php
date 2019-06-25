<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'alunos';
    protected $fillable = [
        "nome",
        "data_nascimento",
        "rg_cpf",
        "instituicao",
        "responsavel",
        "email",
        "telefone",
        "celular",
        "descricao"
    ];

}
