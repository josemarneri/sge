<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Despesa extends Model
{
    use HasFactory;
    protected $table = 'despesas';
    protected $fillable = [
      'id','nome','descricao','ativo'
    ];
    
    public function getByNome($nome){
        $despesa = DB::table('despesas')
                ->where('nome','=',$nome)
                ->get()->all();
        return $despesa;
    }
    public function getLessNome($nome){
        $despesa = DB::table('despesas')
                ->where('nome','<>',$nome)
                ->get()->all();
        return $despesa;
    }
}
