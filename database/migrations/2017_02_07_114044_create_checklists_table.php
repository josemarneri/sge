<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',50)->unique();
            $table->string('descricao',100);
            
            $table->timestamps();
        });
        
        Schema::create('atividade_checklist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('atividade_id')->unsigned();
            $table->integer('checklist_id')->unsigned();
            
            $table->foreign('atividade_id')
                    ->references('id')
                    ->on('atividades')
                    ->onDelete('cascade');
            
            $table->foreign('checklist_id')
                    ->references('id')
                    ->on('checklists')
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
        Schema::dropIfExists('atividade_checklist');
        Schema::dropIfExists('checklists');
    }
}
