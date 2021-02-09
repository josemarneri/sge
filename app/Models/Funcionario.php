<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Funcao;

class Funcionario extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','nome','cpf','rg','regCliente','endereco','telefone', 'email','cargo_id', 'funcao_id' , 'user_id', 'ativo',
    ];
    
    function __construct() {
        //$this->fillable = $fillable;
        $this->ativo = true;
        //$this->id = 100;
    }
    
    
    

    public function User(){
        return $this->belongsTo(\App\User::class);
    }
    
    
    public function getFuncionarioByUserId($id) {
        $funcionario = Funcionario::where('user_id', '=', $id)->get()->first();
        return $funcionario;
    }
    public function getByNome($Nome) {
        $funcionario = Funcionario::where('nome', '=', $nome)->get()->first();
        return $funcionario;
    }
    public function getByCpf($cpf) {
        $funcionario = Funcionario::where('cpf', '=', $cpf)->get()->first();
        return $funcionario;
    }
    
    public function getComessas(){        
        $funcionarios = DB::table('funcionarios')
                ->join('comessa_funcionarios','comessa_funcionarios.funcionario_id','=', 'funcionarios.id')
                ->where('comessa_funcionarios.comessa_id', '=', $this->id )
                ->select('funcionarios.*')
                ->get();
        return $funcionarios;
    }
    
    public function getUserName($idfuncionario){
        $user = User::find($idfuncionario)->name;
        if ($user === "Nulo"){
            return "";
        }else {
            return $user;
        }
    }
    
    public function getByFuncao($funcao, $funcao2 = ''){
		$func = new Funcao();
        $func = $func->getByNome($funcao);
        $id1 = $func->id;
		$id2 = '';
		if (!empty($funcao2)){
			$func = $func->getByNome($funcao2);
			$id2 = $func->id;
		}
		
		$funcionarios = DB::table('funcionarios')
                    ->where('funcao_id','=',$id1)
                    ->orWhere('funcao_id','=',$id2)
                    ->get();
        
        //$funcionarios = Funcionario::where('funcao_id','=',$id)->get();
        
        return $funcionarios;
    }
    
    public function getUserLogin($idfuncionario){
        $user = User::find($idfuncionario)->login;
        if ($user === "Nulo"){
            return "";
        }else {
            return $user;
        }
    }
}
