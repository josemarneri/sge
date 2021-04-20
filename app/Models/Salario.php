<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Cargo;

class Salario extends Model
{
    use HasFactory;
    protected $table = 'salarios';
    protected $fillable = [
      'id','valor_mensal','valor_hora','ativo'  
    ];
    
    public function getCargo($id=0){
        $cs = DB::table('cargo_salarios')
                ->where('salario_id', '=', $id)
                ->get()->first();
        if (!empty($cs)){
            $cargo = Cargo::find($cs->cargo_id);
        }else{
            $cargo = null;
        }     
        
        return $cargo;
    }
    
    public function salvarCargo($request){
        $salario = ['valor_mensal' => $request['valor_mensal'],
                    'valor_hora' => $request['valor_hora'],
                    'ativo' => $request['ativo'] ];
        $id = DB::table('salarios')->insertGetId($salario);
        DB::table('cargo_salarios')->insert([
            'salario_id' => $id,
            'cargo_id' => $request['cargo_id'],
        ]);
    }
    public function getSalarios($cargo_id){
        $salarios = DB::table('salarios')
                 ->join('cargo_salarios','cargo_salarios.salario_id','=', 'salarios.id')
                        ->where('cargo_salarios.cargo_id', '=', $cargo_id )
                        ->select('salarios.*')
                ->get()->all();
        return $salarios;
    }
}
