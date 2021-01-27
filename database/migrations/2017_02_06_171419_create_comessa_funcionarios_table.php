<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComessaFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comessa_funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comessa_id')->unsigned();
            $table->integer('funcionario_id')->unsigned();
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
        Schema::dropIfExists('comessa_funcionarios');
    }
}
