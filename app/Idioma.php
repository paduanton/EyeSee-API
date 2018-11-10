<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $fillable = [
        'descricao',
    ];

    protected $table = 'idioma';
}
