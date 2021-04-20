<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherscolunasFuncionarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('funcionarios', function (Blueprint $table) {
             $table->string('foto')->nullable();
             $table->integer('fornecedor_id')->nullable();
             
             $table->foreign('fornecedor_id')
                    ->references('id')
                    ->on('fornecedores')
                    ->onDelete('cascade');
             
             $table->integer('salario_id')->nullable();
             
             $table->foreign('salario_id')
                    ->references('id')
                    ->on('salarios')
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
        //
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn('foto');
            $table->dropColumn('fornecedor_id');
            $table->dropColumn('salario_id');
        });
    }
}
