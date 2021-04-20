<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Beneficio extends Model
{
    use HasFactory;
    protected $table = 'beneficios';
    protected $fillable = [
      'id','nome','descricao','valor','percentual','desconto_valor',
        'desconto_percentual','ativo' 
    ];
    
    public function limparBeneficiados() {        
        $deletados = DB::table('funcionario_beneficios')
                ->where('beneficio_id', '=', $this->id)
                ->delete();       
        
        return $deletados;
    }   
    
        
    public function addBeneficiados($inclusos) {
        
        if (!empty($inclusos)){
            foreach ($inclusos as $func_id){
                DB::table('funcionario_beneficios')->insert([
                    ['beneficio_id' => $this->id, 'funcionario_id' => $func_id],
                ]);
            }
            return 1;
        }else{
            return 0;
        }        
    }    
}
