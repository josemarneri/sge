<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;

class Atividade extends Model
{
    //
    protected $fillable = [
        'id','codigo','funcionario_id','comessa_id','descricao','horasprev',
        'prev_inicio','prev_fim','titulo','obsconclusao',
        'data_inicio','data_fim','status','avaliacao','obsresponsavel' ];
    
    public function getAnexos(){
        $arquivo = new Arquivo();
        $anexos = $arquivo->ListarDeById('atividades', $this->id);
        return $anexos;
    }
    
    public function Salvar($request){
        $dados;
        foreach($request as $key=>$valor){
            if (in_array($key, $this->fillable)){
                $dados[$key] = $valor;
            }            
        }
        $id = DB::table('atividades')->insertGetId($dados);
        return $id;
    }
    
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
    
    public function getByUser($user){
        $funcionario = new Funcionario();
        $funcionario = $funcionario->getFuncionarioByUserId($user->id);
        $atividades = $this->where('funcionario_id','=',$funcionario->id)
                            ->get();
        return $atividades;
    }
    
    public function getFuncionario(){
        $funcionario = Funcionario::find($this->funcionario_id);
        return $funcionario;
    }
    
    public function getOwnerComessa() 
    {
        $owner = DB::table('funcionarios')
                ->join('comessas','comessas.coordenador_id','=', 'funcionarios.id')
                ->where('comessas.id', '=', $this->comessa_id )
                ->select('funcionarios.*')
                ->get()->first();
        return $owner;
    }
    
    public function getCodigo($comessa_id){
        $comessa = Comessa::find($comessa_id);
        $atividades = Atividade::where('comessa_id','=', $comessa_id)->get()->last();
        if (!empty($atividades)){
            $pos = strrpos($atividades['codigo'], '.');
            $n= substr($atividades['codigo'], $pos+1)+1;
        }else{
            $n=1;
        }

        $codigo =$comessa->codigo.'.'.$n;
        return $codigo;
        //return $comessa->codigo.'.'.$n;
    }
    
    public function limpaChecklists() {        
        DB::table('atividade_checklist')->where('atividade_id', '=', $this->id)->delete();
        return 1;
        
    }    
    
    public function addChecklists($checklists_id) {       
        if(empty($checklists_id)){
            return 0;
        }
        foreach($checklists_id as $checklist_id){
            $existe = count(DB::table('atividade_checklist')
                ->where('atividade_id', '=', $this->id)
                ->where('checklist_id', '=', $checklist_id)->get());
            if($existe<1){
                $cklists[] = ['atividade_id'=>$this->id, 'checklist_id'=>$checklist_id];
            }  
        } 
        if(!empty($cklists)){
            DB::table('atividade_checklist')->insert($cklists);
            return 1;
        }
        return 0;        
    }
    
    public function hasChecklist($checklist_id){
        $cklists = DB::table('atividade_checklist')
                ->where('atividade_id', '=', $this->id)
                ->where('checklist_id', '=', $checklist_id)->get();
        if(count($cklists)>0){
            return true;
        }
        return false;
    }
    
}
