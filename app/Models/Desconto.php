<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Desconto extends Model
{
    use HasFactory;
    protected $table = 'descontos';
    protected $fillable = [
      'id','nome','descricao','valor','percentual','ativo' 
    ];
    
    public function limparDescontados() {        
        $deletados = DB::table('funcionario_descontos')
                ->where('desconto_id', '=', $this->id)
                ->delete();       
        
        return $deletados;
    }   
    
        
    public function addDescontados($inclusos) {
        
        if (!empty($inclusos)){
            foreach ($inclusos as $func_id){
                DB::table('funcionario_descontos')->insert([
                    ['desconto_id' => $this->id, 'funcionario_id' => $func_id],
                ]);
            }
            return 1;
        }else{
            return 0;
        }        
    }    
}
