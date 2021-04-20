<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunasComessa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('comessas', function (Blueprint $table) {            

            $table->double('horas_gastas')->nullable()->after('n_horas'); 
            $table->double('custo_horario')->nullable()->after('horas_gastas');
            $table->string('obs', 250)->nullable()->after('custo_horario');
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
            $table->dropColumn('horas_gastas');
            $table->dropColumn('custo_horario');
            $table->dropColumn('obs');
            $table->dropColumn('gatilho');
            $table->dropColumn('bloqueio');
            $table->dropColumn('user_id');
        });
    }
}
