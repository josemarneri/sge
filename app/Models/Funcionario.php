<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Funcao;
use App\Models\Salario;

class Funcionario extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','nome','cpf','rg','regCliente','endereco','telefone', 'email',
        'salario_id','fornecedor_id','cargo_id', 'funcao_id' , 'user_id', 'ativo',
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
    public function getByUser() {
        $user = auth()->user();
        $funcionario = Funcionario::where('user_id', '=', $user->id)->get()->first();
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
    public function hasBeneficio($beneficio_id){
        $has = DB::table('funcionario_beneficios')
                ->where('beneficio_id','=',$beneficio_id)
                ->where('funcionario_id','=',$this->id)
                ->get()->first();
        if (empty($has)){
            return false;
        }else{
            return true;
        }
    }
    public function hasDesconto($desconto_id){
        $has = DB::table('funcionario_descontos')
                ->where('desconto_id','=',$desconto_id)
                ->where('funcionario_id','=',$this->id)
                ->get()->first();
        if (empty($has)){
            return false;
        }else{
            return true;
        }
    }
    public function getBeneficios() {        
        $beneficios = DB::table('funcionario_beneficios')
                ->join('beneficios', 'beneficios.id', '=','funcionario_beneficios.beneficio_id' )
                ->where('funcionario_beneficios.funcionario_id', '=', $this->id)
                ->where('beneficios.ativo', '=', true)
                ->select('beneficios.*')
                ->get()->all();       
        
        return $beneficios;
    }
    public function getValorBeneficios($n_horas = 180) {        
        $beneficios = DB::table('funcionario_beneficios')
                ->join('beneficios', 'beneficios.id', '=','funcionario_beneficios.beneficio_id' )
                ->where('funcionario_beneficios.funcionario_id', '=', $this->id)
                ->where('beneficios.ativo', '=', true)
                ->select('beneficios.*')
                ->get()->all();  
        $salario = $this->getValorSalario($n_horas);
       $total=0;
       $desconto=0;

        if (!empty($beneficios)){
            foreach ($beneficios as $b){
                $total += $b->valor;
                $total += ($b->percentual * $salario / 100);
                $desconto += $b->desconto_valor;
                $desconto += ($b->desconto_percentual * $salario / 100);
            }          
        }
        return $total;
    }
    public function getValorDescontoBeneficios($n_horas = 180) {        
        $beneficios = DB::table('funcionario_beneficios')
                ->join('beneficios', 'beneficios.id', '=','funcionario_beneficios.beneficio_id' )
                ->where('funcionario_beneficios.funcionario_id', '=', $this->id)
                ->where('beneficios.ativo', '=', true)
                ->select('beneficios.*')
                ->get()->all();  
        $salario = $this->getValorSalario($n_horas);
        $total=0;
        $desconto=0;

        if (!empty($beneficios)){
            foreach ($beneficios as $b){
                $total += $b->valor;
                $total += ($b->percentual * $salario / 100);
                $desconto += $b->desconto_valor;
                $desconto += ($b->desconto_percentual * $salario / 100);
            }          
        }
        return $desconto;
    }
    public function getDescontos() {        
        $descontos = DB::table('funcionario_descontos')
                ->join('descontos', 'descontos.id', '=','funcionario_descontos.desconto_id' )
                ->where('funcionario_descontos.funcionario_id', '=', $this->id)
                ->where('descontos.ativo', '=', true)
                ->select('descontos.*')
                ->get()->all();       
        
        return $descontos;
    }
    public function getValorDescontos($n_horas = 180) {        
        $descontos = DB::table('funcionario_descontos')
                ->join('descontos', 'descontos.id', '=','funcionario_descontos.desconto_id' )
                ->where('funcionario_descontos.funcionario_id', '=', $this->id)
                ->where('descontos.ativo', '=', true)
                ->select('descontos.*')
                ->get()->all();  
        $salario = $this->getValorSalario($n_horas);
       $total=0;
       $desconto=0;

        if (!empty($descontos)){
            foreach ($descontos as $d){
                $total += $d->valor;
                $total += ($d->percentual * $salario / 100);
                $desconto += $d->valor;
                $desconto += ($d->percentual * $salario / 100);
            }          
        }
        return $desconto;
    }

    public function getValorSalario($n_horas = 180){
        $salario = Salario::find($this->salario_id);
        $total=0;
        if (!empty($salario)){
            $total += $salario->valor_mensal;
            $total += ($salario->valor_hora * $n_horas);           
        }
        return $total;
    }
    public function getValorSalarioLiquido($n_horas = 180){
        $salario = $this->getValorSalario($n_horas);
        $beneficios = $this->getValorBeneficios($n_horas);
        $descontoBeneficios = $this->getValorDescontoBeneficios($n_horas);
        $desconto = $this->getValorDescontos($n_horas);
        $total=$salario + $beneficios - $descontoBeneficios - $desconto;

        return $total;
    }
    public function apagarDesconto($desconto_id,$funcionario_id){
        $despesa = DB::table('funcionario_descontos')
                    ->where('desconto_id','=', $desconto_id)
                    ->where('funcionario_id','=', $funcionario_id)
                    ->delete();
        return $despesa;
    }
    public function apagarBeneficio($beneficio_id,$funcionario_id){
        $beneficio = DB::table('funcionario_beneficios')
                    ->where('beneficio_id','=', $beneficio_id)
                    ->where('funcionario_id','=', $funcionario_id)
                    ->delete();
        return $beneficio;
    }
}
