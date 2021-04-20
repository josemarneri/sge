<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Faturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao',250);
            $table->date('data');
            $table->double('valor_calculado');
            $table->double('desconto')->nullable();
            $table->double('valor_nf');
            $table->string('nf')->nullable();
            $table->string('obs')->nullable();                                                                                      
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
        Schema::dropIfExists('faturas');
    }
}
