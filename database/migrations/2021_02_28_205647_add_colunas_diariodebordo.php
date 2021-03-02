<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunasDiariodebordo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diariosdebordo', function (Blueprint $table) {
            $table->string('n_horas_consultivadas')
                   ->nullable() // Preenchimento não obrigatório
                   ->after('descricao'); // Ordenado após a coluna "nome"
            $table->boolean('consultivado') // Nome da coluna
                   ->nullable() // Preenchimento não obrigatório
                   ->after('n_horas_consultivadas'); // Ordenado após a coluna "nome"
            $table->boolean('faturado') // Nome da coluna
                   ->nullable() // Preenchimento não obrigatório
                   ->after('consultivado'); // Ordenado após a coluna "cpf"
            $table->string('nf') // Nome da coluna
                   ->nullable() // Preenchimento não obrigatório
                   ->after('faturado'); // Ordenado após a coluna "cpf"
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diariosdebordo', function (Blueprint $table) {
            $table->dropColumn('n_horas_consultivadas');
            $table->dropColumn('consultivado');
            $table->dropColumn('faturado');
            $table->dropColumn('nf');
        });
    }
}
