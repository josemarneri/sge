<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orcamento_id')
                    ->unsigned();
            $table->double('tarifa', 5 , 2);
            $table->double('n_horas',9,2);
            $table->string('obs', 50)->nullable();           
            $table->string('status',20);
            $table->date('data_envio');
            $table->date('data_resposta')->nullable();
            
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
        Schema::dropIfExists('propostas');
    }
}
