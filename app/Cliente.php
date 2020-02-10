<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'doc',
        'contato',
        'rua',
            'numero',
            'bairro',

    ];
}
