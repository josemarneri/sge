<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome',50);
            $table->string('sigla',10)->unique();
            $table->string('cnpj',11)->nullable();
            $table->string('endereco',50)->nullable();
            $table->string('telefone',50)->nullable();
            $table->string('email',50)->nullable();
            $table->boolean('isCliente')->nullable();
            $table->boolean('isFornecedor')->nullable();
            
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
        Schema::dropIfExists('empresas');
    }
}
