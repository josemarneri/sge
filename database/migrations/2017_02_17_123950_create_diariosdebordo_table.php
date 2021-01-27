<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiariosdebordoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diariosdebordo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comessa_id')->unsigned();
            $table->integer('funcionario_id')->unsigned();
            $table->integer('atividade_id')->unsigned()->nullable();
            $table->string('n_horas');
            $table->date('data');
            $table->string('descricao');            
            $table->foreign('comessa_id')
                    ->references('id')
                    ->on('comessas')
                    ->onDelete('cascade');
            $table->foreign('funcionario_id')
                    ->references('id')
                    ->on('funcionarios')
                    ->onDelete('cascade');
            $table->foreign('atividade_id')
                    ->references('id')
                    ->on('atividades')
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
        Schema::dropIfExists('diariosdebordo');
    }
}
