<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesenhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('desenhos', function (Blueprint $table) {
            $table->increments('id');               // Serve apenas para o BD
            $table->string('numero',20)->unique();   //Numero NSD                     
            $table->string('alias',20)->nullable()->unique();   //Numero de cliente            
            $table->string('descricao',100)->nullable();           
            $table->string('material',200)->nullable();           
            $table->string('peso',20)->nullable();           
            $table->string('tratamento',150)->nullable();           
            $table->string('observacoes',200)->nullable();
            $table->integer('user_id')->unsigned();
            
            //Referencia externa para projetos cadastrados
            $table->integer('projeto_id')->nullable()->unsigned();
            $table->foreign('projeto_id')
                    ->references('id')
                    ->on('projetos')
                    ->onDelete('cascade');
            
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            
            $table->timestamps();
        });
        
        Schema::create('conjuntos', function (Blueprint $table) {
        		$table->increments('id');
        		$table->integer('pai_id')->unsigned();
        		$table->integer('filho_id')->unsigned();
        		
        		
        		$table->foreign('pai_id')
        		->references('id')
        		->on('desenhos')
        		->onDelete('cascade');
        		
        		$table->foreign('filho_id')
        		->references('id')
        		->on('desenhos')
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
        Schema::dropIfExists('conjuntos');
        Schema::dropIfExists('desenhos');
    }
}
