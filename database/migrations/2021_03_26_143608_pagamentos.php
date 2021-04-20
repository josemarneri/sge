<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('despesa_id');
            $table->integer('funcionario_id')->nullable();
            $table->integer('comessa_id')->nullable();
            $table->double('valor');
            $table->double('valor_beneficio')->nullable();
            $table->double('valor_descontos')->nullable();
            $table->double('juros')->nullable();
            $table->date('data_vencimento');
            $table->date('data_pagamento');
            $table->double('valor_pago');
            $table->string('obs',200)->nullable(); 
            
            $table->foreign('despesa_id')
                        ->references('id')
                        ->on('despesas')
                        ->onDelete('cascade');
            $table->foreign('funcionario_id')
                        ->references('id')
                        ->on('funcionarios')
                        ->onDelete('cascade');
            $table->foreign('comessa_id')
                        ->references('id')
                        ->on('comessas')
                        ->onDelete('cascade');
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
        //
        Schema::dropIfExists('pagamentos');
    }
}
