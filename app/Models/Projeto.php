<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','codigo', 'descricao','observacoes', 'comessa_id'
    ];
    
    public function getProjetoByCodigo($codigo){
        $projeto = Projeto::where('codigo','=',$codigo)->get()->first();
        if(!empty($projeto)){
            return $projeto;
        }
        return null;
    }
    public function getCodigoById($id){
        $projeto = Projeto::find($id);
        //$projeto = Projeto::where('id','=',$id)->get()->first();
        if(!empty($projeto)){
            return $projeto->codigo;
        }
        return null;
    }
}
