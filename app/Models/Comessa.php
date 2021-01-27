<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Funcionario;
use App\Models\Cliente;
use App\Models\Orcamento;
use App\Models\ComessaFuncionario;
use Illuminate\Support\Facades\DB;

class Comessa extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','orcamento_id','codigo','descricao','n_horas','data_inicio','data_fim','gerente_id', 'coordenador_id', 'ativa',
    ];
    
    public function getFuncionario($id){
        $funcionario = Funcionario::find($id);
        return $funcionario;
    }
    
    public function getNomeFuncionario($id){
        $funcionario = Funcionario::find($id);
        $nome = $funcionario ? $funcionario->nome : null;
        return $nome;
    }
    /**
     * Return the comessa's staffs .
     *@return collection Collection of objects Funcionario 
     * @var array
     */
    public function getFuncionarios(){        
        $funcionarios = DB::table('funcionarios')
                ->join('comessa_funcionarios','comessa_funcionarios.funcionario_id','=', 'funcionarios.id')
                ->where('comessa_funcionarios.comessa_id', '=', $this->id )
                ->orderBy('funcionarios.nome')
                ->select('funcionarios.*')
                ->get();
        return $funcionarios;
    }

    public function limpaEquipe() {
        $cfs = ComessaFuncionario::where('comessa_id', '=', $this->id)->get(); 
        if(count($cfs)<1){
            return 0;
        }        
        foreach ($cfs as $cf) {
            $cf->delete();
        } 
        return 1;
        
    }    
    
    public function addEquipe($comessa_id, $funcionarios_id) {       
        if(empty($funcionarios_id)){
            return 0;
        }
        foreach($funcionarios_id as $funcionario_id){
            $existe = count(ComessaFuncionario::where('comessa_id','=',$comessa_id)
                    ->where('funcionario_id','=',$funcionario_id)->get());
            if($existe<1){
                $cf = new ComessaFuncionario();
                $cf->funcionario_id = $funcionario_id; 
                $cf->comessa_id = $comessa_id;
                $cf->save();
            }
            
        }  
        return 1;
    }
    
    public function getCodigo($orcamento_id){
        $orcamento = Orcamento::find($orcamento_id);
        $cliente = Cliente::find($orcamento->cliente_id);
        $comessas = Comessa::where('orcamento_id','=', $orcamento_id)->get()->last();
        
        if (!empty($comessas)){
            $pos = strrpos($comessas['codigo'], '.');
            $n= substr($comessas['codigo'], $pos+1)+1;
        }else{
            $n=1;
        }
        
        $codigo =$cliente->sigla . '.' . $orcamento_id . '.' . $n;
        //dd($codigo);
        return $codigo;
    }
    
    public function getByCoordenador($coordenador_id) {
        $comessas = Comessa::where('comessas.coordenador_id','=', $coordenador_id)
                        ->get();
        return $comessas;
    }
    
    public function getCoordenador(){
        $coordenador = Funcionario::find($this->coordenador_id);
        return $coordenador;
    }
    
    public function getGerente(){
        $gerente = Funcionario::find($this->gerente_id);
        return $gerente;
    }
    
    public function getOrcamento(){
        $orcamento = Orcamento::find($this->orcamento_id);
        return $orcamento;
    }
    public function getDataYmdToDmY($data){
        $df = \DateTime::createFromFormat('Y-m-d', $data); 
        $data = $df->format('d/m/Y');
        return $data;
    }
    public function getDataDmyToYmd($data){
        $df = \DateTime::createFromFormat('d/m/Y', $data); 
        $data = $df->format('Y-m-d');
        return $data;
    }
}
