<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pergunta;
use Illuminate\Support\Facades\DB;

class Checklist extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','nome','descricao' ];
    
    public function getByName($nome){
        $checklist = $this->where('nome','=',$nome)->get()->first();
        return $checklist;
    }


    public function getPerguntas(){
        $perguntas = DB::table('perguntas')
                ->where('perguntas.checklist_id', '=', $this->id )
                ->get();
        return $perguntas;
    }
    public function getQtdePerguntas(){
        $perguntas = Pergunta::where('checklist_id', '=', $this->id )
                ->get();
        return count($perguntas);
    }
    
    public function addPerguntas($perguntas) {       
        if(count($perguntas)==0){
            return 0;
        }
        foreach($perguntas as $p){
            if(!empty($p)){
                $pergunta = new Pergunta();
                $pergunta->checklist_id = $this->id; 
                $pergunta->descricao = $p;
                $pergunta->save(); 
            }
                           
        }  
        return 1;
    }
}
