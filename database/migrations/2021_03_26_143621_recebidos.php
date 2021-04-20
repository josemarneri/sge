<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Recebidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'id','descricao','valor','fatura_id','data','obs'
        Schema::create('recebidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao',250);            
            $table->double('valor');
            $table->integer('fatura_id')->nullable();
            $table->date('data');
            $table->string('obs')->nullable();  
            
            $table->foreign('fatura_id')
                    ->references('id')
                    ->on('faturas')
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
        Schema::dropIfExists('recebidos');
    }
}
