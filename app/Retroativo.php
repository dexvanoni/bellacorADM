<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retroativo extends Model
{
	protected $table = 'retroativo';
    protected $fillable = [
        'quem',
        'valor',
    ];
}
