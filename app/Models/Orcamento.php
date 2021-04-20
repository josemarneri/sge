<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Arquivo;
use App\Models\Proposta;

class Orcamento extends Model
{
    //  
    protected $table = 'orcamentos';
    protected $fillable = [
        'id','cliente_id','descricao','n_horas','horas_gastas','tarifa',
        'valor_total','valor_faturado','custo_inicial','custo_mensal',
        'impostos','obs','gatilho','bloqueio','status', 'pedido','user_id', 'anexo_id',
    ];
    
    public function getCliente($id=0){
        if ($id == 0){
            $orcamento = $this::find($this->id);
        }else{
            $orcamento = $this::find($id);
        }
        
        return Cliente::find($orcamento->cliente_id);
    }
    
    public function getAnexos($id){
        $arquivo = new Arquivo();
        $anexos = $arquivo->ListarDeById('orcamentos', $id);
        return $anexos;
    }
    
    public function getPropostas($idorcamento){
        $proposta = new Proposta();
        $propostas = Proposta::where('orcamento_id','=',$idorcamento)->get();
        return $propostas;
    }
}
