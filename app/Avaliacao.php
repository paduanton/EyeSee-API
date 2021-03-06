<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'ultima_alteracao';

    protected $fillable = [
        'descricao', 'nota',
    ];

    protected $table = 'avaliacao';

}