<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Beneficios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',50);
            $table->string('descricao',200)->nullable();
            $table->double('valor');
            $table->double('percentual');                       
            $table->double('desconto_valor')->nullable();
            $table->double('desconto_percentual')->nullable();                       
            $table->boolean('ativo');                       
            $table->timestamps();
        });
        
        Schema::create('funcionario_beneficios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('funcionario_id');
            $table->integer('beneficio_id');
            
            $table->foreign('funcionario_id')
                    ->references('id')
                    ->on('funcionarios')
                    ->onDelete('cascade');
            
            $table->foreign('beneficio_id')
                    ->references('id')
                    ->on('beneficios')
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
        Schema::dropIfExists('funcionario_beneficios');
        Schema::dropIfExists('beneficios');
    }
}
