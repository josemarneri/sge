<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Diariodebordo;
use Illuminate\Support\Facades\DB;

class Financeiro extends Model
{
    use HasFactory;
    
    
    public function Filtrar($filtro){
        $ddb = new Diariodebordo();
        $de = $filtro['de'];
        $ate = $filtro['ate'];
        $comessa_id = $filtro['comessa_id'];

        $funcionarios_id=$filtro['funcionario_id'];
        $resultado;
        $ddbs;
        
        foreach ($funcionarios_id as $f_id){
            $query = DB::table('diariosdebordo')
                    ->where('funcionario_id', '=', $f_id)
                    ->where('data', '>=', $de)
                    ->where('data', '<=', $ate);
            
            if(!empty($comessa_id)){
                $query->where('comessa_id','=',$comessa_id);
            }
            $ddbs[$f_id] = $query->get()->all();
        }        
        $resultado = $ddbs;
//        $resultado['all'] = $desenhos->get()->all(); 
//        $resultado['pag'] = $desenhos->paginate(); 
        //dd($desenhos);
        return $resultado;
        //return $resultado;
        
    }
}
