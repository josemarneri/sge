<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunasOrcamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('orcamentos', function (Blueprint $table) {
            
            $table->double('n_horas')->after('descricao'); 
            $table->double('horas_gastas')->nullable()->after('n_horas'); 
            $table->double('tarifa')->after('horas_gastas');
            $table->double('valor_total')->nullable()->after('tarifa');
            $table->double('valor_faturado')->nullable()->after('valor_total');
            $table->double('custo_inicial')->nullable()->after('valor_faturado');
            $table->double('custo_mensal')->nullable()->after('custo_inicial');
            $table->double('impostos')->nullable()->after('custo_mensal');
            $table->string('obs', 250)->nullable()->after('pedido');
            $table->double('gatilho')->nullable()->after('obs');
            $table->boolean('bloqueio')->after('gatilho');
            
            $table->integer('user_id')->after('obs');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('user')
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
        Schema::table('orcamentos', function (Blueprint $table) {
            $table->dropColumn('n_horas');
            $table->dropColumn('horas_gastas');
            $table->dropColumn('tarifa');
            $table->dropColumn('valor_total');
            $table->dropColumn('valor_faturado');
            $table->dropColumn('custo_inicial');
            $table->dropColumn('custo_mensal');
            $table->dropColumn('impostos');
            $table->dropColumn('obs');
            $table->dropColumn('gatilho');
            $table->dropColumn('bloqueio');
            $table->dropColumn('user_id');
        });
    }
}
