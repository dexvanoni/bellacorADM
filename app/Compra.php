<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
        protected $fillable = [
        'item',
        'quantidade',
        'valor_pago',
        'num_parcelas',
        'fornecedor',
        'quem_pagou',
        'forma_pagamento',
        'quem_comprou',
        'tipo',

    ];
}
