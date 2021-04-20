<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Despesas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        //'id','nome','descricao','valor','percentual'
        Schema::create('despesas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',50);
            $table->string('descricao',200)->nullable();                                            
            $table->boolean('ativo');                                            
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
        Schema::dropIfExists('despesas');
    }
}
