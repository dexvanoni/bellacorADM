<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'produto',
        'quantidade',
        'cliente',
        'valor_pago',
        'forma_pagamento',
        'num_parcelas',
        'valor_entrada',
        'obs',
        'entrega',
        'situacao',
        'dt_entrega',
        'pago',
        'custo',
        'tipo',

    ];
}
