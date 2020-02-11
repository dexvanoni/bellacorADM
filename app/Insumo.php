<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'insumo',
        'un',
        'valor',
    ];
}
