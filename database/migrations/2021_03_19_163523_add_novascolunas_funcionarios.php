<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNovascolunasFuncionarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('funcionarios', function (Blueprint $table) {
             $table->string('empresa_id') // Nome da coluna
                    ->nullable() // Preenchimento não obrigatório
                    ->after('nome'); // Ordenado após a coluna "nome" 
             $table->foreign('empresa_id')
                    ->references('id')
                    ->on('empresas')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn('empresa_id');
        });
    }
}
