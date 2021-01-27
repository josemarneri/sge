<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Comessa;
use App\Models\Atividade;
use App\Models\Funcionario;

class Diariodebordo extends Model
{
    use HasFactory;
    protected $table = 'diariosdebordo';
    
    protected $fillable = [
        'id','funcionario_id','comessa_id','atividade_id','data','descricao','n_horas'];
    
    public function formatDateToYMD($date){
        $df = \DateTime::createFromFormat('d/m/Y', $date); 
        $data = $df->format('Y-m-d');
        return $data;
    }
    
    public function formatDateToDMY($date){       
        $df = \DateTime::createFromFormat('Y-m-d', $date); 
        $data = $df->format('d/m/Y');
        return $data;
    }
    
    public function getFuncionarioByUser(){
        $user = auth()->user();
        $funcionario = new Funcionario();
        $funcionario = $funcionario->getFuncionarioByUserId($user->id);
        return $funcionario;
    } 
    
    public function getFuncionario(){
        $funcionario = Funcionario::find($this->funcionario_id);
        return $funcionario;
    }
    
    public function getComessa() {
        $comessa = Comessa::find($this->comessa_id);
        return $comessa;
    }
    
    public function getOwnerComessa() {
        $owner = DB::table('funcionarios')
                ->join('comessas','comessas.coordenador_id','=', 'funcionarios.id')
                ->where('comessas.id', '=', $this->comessa_id )
                ->select('funcionarios.*')
                ->get()->first();
        return $owner;
    }
    
    public function getAtividade() {
        $atividade = Atividade::find($this->atividade_id);
        return $atividade;
    }
    
    public function getComessas() {
        $funcionario = $this->getFuncionarioByUser();
        $comessas = DB::table('comessa_funcionarios')
                ->join('comessas', 'comessas.id','=','comessa_funcionarios.comessa_id')
                ->where('comessa_funcionarios.funcionario_id','=',$funcionario->id)
                ->select('comessas.*')->get();
        return $comessas;
    }
    
    public function getAtividades($comessa_id) {
        $funcionario = $this->getFuncionarioByUser();
        $atividades = DB::table('atividades')
                ->where('comessa_id','=',$comessa_id)
                ->where('funcionario_id','=',$funcionario->id)
                ->select('atividades.*')->get();
        return $atividades;
    }
    
    public function getByUser(){
       $funcionario = $this->getFuncionarioByUser();
       $dbs = $this->where('funcionario_id','=',$funcionario->id)->get();
        return $dbs;
    }
    
    public function getLancamentosPendetes(){
        $funcionario = $this->getFuncionarioByUser();
        $lanc_pendentes = DB::table('lancamentos_pendentes')
                ->where('funcionario_id','=',$funcionario->id)
                ->get();
        $pendencias = null;
        foreach($lanc_pendentes as $value){
            //$data = $value->data;
            $data = $this->formatDateToDMY($value->data);
            $pendencias[$data] = $value->data;
        }        
        return $pendencias;
    }


    public function getHorasPendentes($data){
        $funcionario = $this->getFuncionarioByUser();
        $horas_pendentes = DB::table('lancamentos_pendentes')
                ->where('funcionario_id','=',$funcionario->id)
                ->where('data','=',$data)
                ->get()->first(); 
        if(!empty($horas_pendentes)){
            return $horas_pendentes->horas_pendentes;
        }
        
        return 0;
    }
    
    public function Salvar($request){
        if (!empty($this->id)){  
            $this->fill($request->toArray()); 
            $this->save();   
            $this->AtualizarPendencia($request); 
            $mensagem = "Diariodebordo ".$this->id." atualizado com sucesso ";
        }else {
            $request['id']=$this->id;
            $this->create($request->toArray());
            $this->AtualizarPendencia($request);            
            $mensagem = 'Diariodebordo cadastrado com sucesso';
        }
        return $mensagem;
    }  

    public function AtualizarPendencia($request){
        $saldo = $request['horas_pendentes'] - $request['n_horas'];        
        if(!$this->hasPendencia($request['data']) && $saldo>0){
            $this->CriarPendencia($request['data'], $saldo);
            return 2;
        }
        
        if ($saldo>0){
            $this->ChangePendencia($request['data'], $saldo);
            return 1;
        }else if ($saldo == 0){
            $this->ApagarPendencia($request['data']);
            return 0;
            }else {
                $request['n_horas'] += $this->getHorasPendentes($request['data']);
                if($this->hasPendencia($request['data'])){
                    $this->ChangePendencia($request['data'], $request['n_horas']);
                }else
                    $this->CriarPendencia($request['data'], $request['n_horas']);
            }
        
        return -1;        
    }
    
    public function ApagarPendencia($data){
        DB::table('lancamentos_pendentes')
            ->where('data','=',$data)
            ->where('funcionario_id','=',$this->getFuncionarioByUser()->id)
            ->delete();
    }
    
    public function CriarPendencia($data,$horas){
        DB::table('lancamentos_pendentes')->insert([
                    ['data' => $data, 
                    'funcionario_id' => $this->getFuncionarioByUser()->id,
                       'horas_pendentes'=> $horas],
                ]);
    }
    
    public function hasPendencia($data){
        $lp = DB::table('lancamentos_pendentes')
            ->where('data','=',$data)
            ->where('funcionario_id','=',$this->getFuncionarioByUser()->id)->first();
        return !empty($lp);
    }
    
    public function ChangePendencia($data,$horas){
        DB::table('lancamentos_pendentes')
            ->where('data','=',$data)
            ->where('funcionario_id','=',$this->getFuncionarioByUser()->id)
            ->update(['horas_pendentes'=>$horas]);
    }
}
