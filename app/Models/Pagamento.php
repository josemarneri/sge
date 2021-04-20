<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pagamento extends Model
{
    use HasFactory;
    protected $table = 'pagamentos';
    protected $fillable = [
      'id','despesa_id','funcionario_id','comessa_id','valor',
        'valor_beneficios','valor_descontos','juros',
        'data_vencimento','data_pagamento','valor_pago','obs'
    ];
    
    public function getFillable() {
        return $this->fillable;
    }
    
    public function getAtributos(){
    	return $this->fillable;
    } 

    function setFillable($fillable) {
        $this->fillable = $fillable;
    }
    
    function getNomeDespesa($despesa_id){
        $despesa = Despesa::find($despesa_id);
        return (!empty($despesa))? $despesa->nome : null;
    }

    function getById($id) {
        $pagamento = $this->where('id','=',$id)->first();
        return $pagamento;
    }

    public function Filtrar($filtro){
        $pagamento = new Pagamento();
        $pagamentos = DB::table('pagamentos');
        $despesa = new Despesa();
        $key = 'data_pagamento';
        $valor = 'desc';
        $resultado;
        if(!empty($filtro['filtrofuncionario_id'])){
            $pagamentos->where('funcionario_id','=',$filtro['filtrofuncionario_id']);
        }
        
        if(!empty($filtro['filtrodata_inicial'])){
            $pagamentos->where('data_pagamento','>=',$filtro['filtrodata_inicial']);
        }
        if(!empty($filtro['filtrodata_final'])){
            $pagamentos->where('data_pagamento','<=',$filtro['filtrodata_final']);
        }
        if(!empty($filtro['filtroobs'])){
            $pagamentos->where('obs','like','%'.$filtro['filtroobs'].'%');
        }
       
        if(!empty($filtro['filtrodespesa_id'])){
                $pagamentos->where('despesa_id','=',$filtro['filtrodespesa_id']);           
            //$pagamentos->take($filtro['maxresult']);             
        }
        if(!empty($filtro['filtrocomessa_id'])){
                $pagamentos->where('comessa_id','=',$filtro['filtrocomessa_id']);           
            //$pagamentos->take($filtro['maxresult']);             
        }
        $pagamentos->orderBy($key,$valor);
        
        $resultado['all'] = $pagamentos->get()->all(); 
        $resultado['pag'] = $pagamentos->paginate(); 
        //dd($pagamentos);
        return $resultado;
        
    }
       
    public function getAnexos($id){
        $arquivo = new Arquivo();
        $anexos = $arquivo->ListarDeById('pagamentos', $id);
        return $anexos;
    }


}
