<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Salarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('salarios', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor_mensal');
            $table->double('valor_hora');                       
            $table->boolean('ativo');                       
            $table->timestamps();
        });
        
        Schema::create('cargo_salarios', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('salario_id')->unsigned();
                $table->integer('cargo_id')->unsigned();

                $table->foreign('salario_id')
                        ->references('id')
                        ->on('salarios')
                        ->onDelete('cascade');

                $table->foreign('cargo_id')
                        ->references('id')
                        ->on('cargo')
                        ->onDelete('cascade');
                $table->timestamps();
        });
        Schema::create('historico_salarios', function (Blueprint $table) {
                $table->increments('id');
                $table->double('valor_mensal');
                $table->double('valor_hora'); 
                $table->integer('cargo_id')->unsigned();
                $table->integer('funcionario_id')->unsigned();
                $table->integer('data')->unsigned();

                $table->foreign('cargo_id')
                        ->references('id')
                        ->on('cargo')
                        ->onDelete('cascade');
                
                $table->foreign('funcionario_id')
                        ->references('id')
                        ->on('funcionarios')
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
        Schema::dropIfExists('historico_salarios');
        Schema::dropIfExists('cargo_salarios');
        Schema::dropIfExists('salarios');
    }
}
