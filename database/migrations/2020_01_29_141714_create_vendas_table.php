<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('produto');
            $table->integer('quantidade');
            $table->string('cliente');
            $table->float('valor_cobrar');
            $table->float('valor_pago');
            $table->string('forma_pagamento');
            $table->integer('num_parcelas');
            $table->float('valor_entrada');
            $table->longText('obs');
            $table->string('entrega');
            $table->string('situacao');
            $table->date('dt_entrega');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
