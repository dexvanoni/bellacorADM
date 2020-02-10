<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'produto',
        'un',
        'valor_venda',
        'valor_custo',
            'obs',
            'tipo',
            'estoque',
            'quem_comprou',

    ];
}
