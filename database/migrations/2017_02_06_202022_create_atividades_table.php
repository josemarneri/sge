<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo',50)->unique();
            $table->integer('comessa_id')->unsigned();
            $table->integer('funcionario_id')->unsigned();
            $table->string('horasprev');
            $table->date('prev_inicio');
            $table->date('prev_fim');
            $table->string('titulo',100);
            $table->string('descricao',200);
            $table->string('obsconclusao',200)->nullable();            
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->string('status',30);
            $table->double('avaliacao')->nullable();            
            $table->string('obsresponsavel',200)->nullable();            
            $table->foreign('comessa_id')
                    ->references('id')
                    ->on('comessas')
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
        Schema::dropIfExists('atividades');
    }
}
