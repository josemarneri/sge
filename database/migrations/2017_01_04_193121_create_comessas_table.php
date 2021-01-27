<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComessasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comessas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orcamento_id')->unsigned();
            $table->string('codigo',50)->unique();
            $table->string('descricao',255);
            $table->double('n_horas');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->integer('gerente_id')->unsigned();
            $table->integer('coordenador_id')
                    ->nullable()
                    ->unsigned();
            $table->boolean('ativa');
            
            $table->foreign('gerente_id')
                    ->references('id')
                    ->on('funcionarios')
                    ->onDelete('cascade');
            
            $table->foreign('coordenador_id')
                    ->references('id')
                    ->on('funcionarios')
                    ->onDelete('cascade');
            
            $table->foreign('orcamento_id')
                    ->references('id')
                    ->on('orcamentos')
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
        Schema::dropIfExists('comessas');
    }
}
