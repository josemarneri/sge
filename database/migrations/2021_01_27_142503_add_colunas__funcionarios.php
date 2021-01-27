<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunasFuncionarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
             $table->string('cpf') // Nome da coluna
                    ->nullable() // Preenchimento não obrigatório
                    ->after('nome'); // Ordenado após a coluna "nome"
             $table->string('rg') // Nome da coluna
                    ->nullable() // Preenchimento não obrigatório
                    ->after('cpf'); // Ordenado após a coluna "cpf"
             $table->string('regCliente') // Nome da coluna
                    ->nullable() // Preenchimento não obrigatório
                    ->after('rg'); // Ordenado após a coluna "cpf"

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
            $table->dropColumn('cpf');
            $table->dropColumn('rg');
            $table->dropColumn('regCliente');
        });
    }
}
