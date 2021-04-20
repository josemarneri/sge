<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descontos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',50);
            $table->string('descricao',200)->nullable();
            $table->double('valor');
            $table->double('percentual');                                             
            $table->boolean('ativo');                       
            $table->timestamps();
        });
        
        Schema::create('funcionario_descontos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('funcionario_id');
            $table->integer('desconto_id');
            
            $table->foreign('funcionario_id')
                    ->references('id')
                    ->on('funcionarios')
                    ->onDelete('cascade');
            
            $table->foreign('desconto_id')
                    ->references('id')
                    ->on('descontos')
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
        Schema::dropIfExists('funcionario_descontos');
        Schema::dropIfExists('descontos');
    }
}
