<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespostaChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resposta_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('atividade_id')->unsigned();
            $table->integer('pergunta_id')->unsigned();
            $table->string('resposta',3);
            $table->foreign('atividade_id')
                    ->references('id')
                    ->on('atividades')
                    ->onDelete('cascade');
            $table->foreign('pergunta_id')
                    ->references('id')
                    ->on('perguntas')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        
        Schema::dropIfExists('resposta_checklists');
    }
}
