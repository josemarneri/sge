<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;
use App\Models\Comessa;

class Carga extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','funcionario_id','comessa_id','data_inicio','data_fim','obs', 'livre' ];
    protected $coordenador_id;

    public function getFuncionarioSemCarga() {
        $funcionarios = new Funcionario();
        $cargas = $this->all();  
        foreach ($cargas as $carga) {
            $funcionarios = $funcionarios->where('id','<>',$carga->funcionario_id );
        }
        return $funcionarios->orderBy('nome', 'asc')->get();
    }
    
    public function getCargaByCoordenador($coordenador_id) {
        $this->coordenador_id = $coordenador_id;
        $cargas = DB::table('cargas')
                ->join('comessas', function($join){
                    $join->on('cargas.comessa_id', '=', 'comessas.id')
                            ->where('comessas.coordenador_id','=', $this->coordenador_id)
                            ->select('cargas.*');
                })->get();
        return $cargas;
    }
    
    public function getByFuncionario($funcionario_id) {
        $carga = $this->where('funcionario_id','=', $funcionario_id)
                            ->get()->first();
        return $carga;
    }
    
    public function getByComessa($comessa_id) {
        $funcionarios = new Funcionario();
        $cargas = Carga::where('comessa_id', '=', $comessa_id)->get(); 
        if(count($cargas)<1){
            return null;
        }
        foreach ($cargas as $carga) {
            $funcionarios = $funcionarios->orwhere('id','=',$carga->funcionario_id );
        }
        return $funcionarios->orderBy('nome', 'asc')->get();
    }
    
    public function getLivres() {
        $funcionarios = new Funcionario();
        $cargas = Carga::where('livre', '=', 1)->get();
        if(empty($cargas)){
            return null;
        }
        foreach ($cargas as $carga) {
            $funcionarios = $funcionarios->orwhere('id','=',$carga->funcionario_id );
        }
        return $funcionarios->orderBy('nome', 'asc')->get();
    }
    
    
    
    public function getOcupados() {
        $funcionarios = new Funcionario();
        $cargas = Carga::where('livre', '=', 0)->get();
        if(empty($cargas)){
            return null;
        }
        foreach ($cargas as $carga) {
            $funcionarios = $funcionarios->orwhere('id','=',$carga->funcionario_id );
        }
        return $funcionarios->orderBy('nome', 'asc')->get();
    }
    
    public function getNomeFuncionario($id) {
        $funcionario = Funcionario::find($id);
        return $funcionario->nome;
    }
    
    public function getCodigoComessa($id) {
        $comessa = Comessa::find($id);
        return $comessa->codigo;
    }
    
    public function getInforComessa(){
        $comessa = Comessa::find($this->comessa_id);
        $infor = 'Descrição: '.$comessa->descricao."\n";
        $infor .= 'Início: '.$comessa->data_inicio."\n";
        $infor .= 'Término: '.$comessa->data_fim."\n";
        $infor .= 'Responsável: '.$comessa->getNomeFuncionario($comessa->coordenador_id)."\n";      
        $infor .= 'Gerente: '.$comessa->getNomeFuncionario($comessa->gerente_id)."\n";
        return $infor;
    }
    
    public function limpaEquipe($comessa_id) {
        $cargas = Carga::where('comessa_id', '=', $comessa_id)->get(); 
        if(count($cargas)<1){
            return 0;
        }
        foreach ($cargas as $carga) {
            $carga->comessa_id = 4;
            $carga->livre = 1;
            $carga->save();
        }
        return 1;
        
    }
    
    // Função para travar o funcionário na comessa, não deixando ele livre
    public function addEquipe($comessa_id, $funcionarios_id) {
        $comessa = Comessa::find($comessa_id);
        $carga = new Carga();
        if(empty($funcionarios_id)){
            return 0;
        }
        foreach($funcionarios_id as $funcionario_id){
            $carga = $this->getByFuncionario($funcionario_id); 
            $carga->comessa_id = $comessa_id;
            $carga->data_inicio = $comessa->data_inicio;
            $carga->data_fim = $comessa->data_fim;
            $carga->livre = 0;
            $carga->save();
        }  
        return 1;
    }
    
    public function getFuncionario(){
        $funcionario = Funcionario::find($this->funcionario_id);
        return $funcionario;
    }
    
    public function getComessa(){
        $comessa = Comessa::find($this->comessa_id);
        return $comessa;
    }
    
    public function getCoordenador() 
    {
        $coordenador = DB::table('funcionarios')
                ->join('comessas','comessas.coordenador_id','=', 'funcionarios.id')
                ->where('comessas.id', '=', $this->comessa_id )
                ->select('funcionarios.*')
                ->get()->first();
        return $coordenador;
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
