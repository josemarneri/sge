<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('funcionario_id')->unsigned();
            $table->integer('comessa_id')->unsigned();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string('obs',250)->nullable();
            $table->boolean('livre');
            
            $table->unique('funcionario_id');
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
        Schema::dropIfExists('cargas');
    }
}
