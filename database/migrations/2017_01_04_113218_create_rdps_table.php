<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRdpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdps', function (Blueprint $table) {
            $table->integer('funcionario_id')->unsigned();
            $table->date('data');
            $table->string('entr1',20);
            $table->string('entr2',20);
            $table->string('sai1',20);
            $table->string('sai2',20);
            $table->string('htrab',20)->nullable();
            $table->string('habon',20)->nullable();
            $table->string('hdeb',20)->nullable();

            
            $table->foreign('funcionario_id')
                    ->references('id')
                    ->on('funcionarios')
                    ->onDelete('cascade');
            $table->primary(array('funcionario_id', 'data')); 
            $table->timestamps();
        });
        
        Schema::create('lancamentos_pendentes', function (Blueprint $table) {
            $table->integer('funcionario_id')->unsigned();
            $table->date('data');
            $table->double('horas_pendentes'); 
            $table->foreign('funcionario_id')
                    ->references('id')
                    ->on('funcionarios')
                    ->onDelete('cascade');
            $table->primary(array('funcionario_id', 'data'));
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
        Schema::dropIfExists('lancamentos_pendentes');
        Schema::dropIfExists('rdps');
    }
}
