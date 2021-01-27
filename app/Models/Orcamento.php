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
        'id','cliente_id','descricao','status', 'pedido', 'anexo_id',
    ];
    
    public function getCliente($id){
        $orcamento = $this::find($id);
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
