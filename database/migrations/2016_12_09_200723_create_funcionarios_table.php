<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->integer('id')
                    ->unsigned()
                    ->unique();
            $table->string('nome',50);
            $table->string('endereco',50)->nullable();
            $table->string('telefone',50)->nullable();
            $table->string('email',50)->nullable();
            $table->integer('cargo_id')
                    ->unsigned()
                    ->nullable();
            $table->integer('funcao_id')
                    ->unsigned()
                    ->nullable();
            $table->integer('user_id')
                    ->unsigned()
                    ->nullable();
            $table->boolean('ativo');
            
            $table->primary('id');
            
            $table->foreign('cargo_id')
                    ->references('id')
                    ->on('cargos')
                    ->onDelete('cascade');
            $table->foreign('funcao_id')
                    ->references('id')
                    ->on('funcoes')
                    ->onDelete('cascade');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('funcionarios');
    }
}
