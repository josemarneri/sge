<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrcamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')
                    ->unsigned();
            $table->string('descricao', 50);            
            $table->string('status',20);
            $table->string('pedido',25)->nullable();
            $table->integer('anexo_id')
                    ->nullable()
                    ->unsigned();
            
            $table->foreign('cliente_id')
                    ->references('id')
                    ->on('clientes')
                    ->onDelete('cascade');            
            
            $table->foreign('anexo_id')
                    ->references('id')
                    ->on('arquivos')
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
        Schema::dropIfExists('orcamentos');
    }
}
