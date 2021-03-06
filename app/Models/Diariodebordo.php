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
        'id','funcionario_id','comessa_id','atividade_id','data','descricao','n_horas', 
        'n_horas_consultivadas' ,'consultivado', 'faturado', 'nf'];
    
    public function getDDB($request){
        $ddb = DB::table('diariosdebordo')
                ->where('funcionario_id','=',$request['funcionario_id'])
                ->where('comessa_id','=',$request['comessa_id'])
                ->where('atividade_id','=',$request['atividade_id'])
                ->where('data', '=', $request['data'])
                ->get()->first();
        return $ddb;
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
    
    public function getAtividadeCodigo() {
        $atividade = Atividade::find($this->atividade_id);
        $resumo = null;
        if (!empty($atividade)){
            $resumo = $atividade->codigo;;
        }
        
        return $resumo;
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
        if (count($atividades)<1){
            $atividades = null;
        }
        return $atividades;
    }
    
    public function getByUser(){
       $funcionario = $this->getFuncionarioByUser();
       $diariosdebordo = $this->where('funcionario_id','=',$funcionario->id)
               ->orderBy('created_at', 'desc')
               ->paginate(30);
       
        return $diariosdebordo;
    }
    
    //Separa um periodo em meses
    //
    public function separarPeriodos($periodo){
        $firstYear = date("Y", strtotime($periodo['de']));
        $firstMonth = date("m", strtotime($periodo['de']));
        $firstDay = date("d", strtotime($periodo['de']));
        $lastYear = date("Y", strtotime($periodo['ate']));
        $lastMonth = date("m", strtotime($periodo['ate']));
        $lastDay = date("d", strtotime($periodo['ate']));
        $de = date("Ymd", strtotime($periodo['de']));
        $ate = date("Ymd", strtotime($periodo['ate']));
        $intervalos;
//        dd($firstYear,$firstMonth,$firstDay,'-',$lastYear,$lastMonth,$lastDay, $ate, $de, $intervalo);
        $inicioMes = date("Y-m-d", strtotime($periodo['de']));
        $lastDayMonth = cal_days_in_month(CAL_GREGORIAN, $firstMonth, $firstYear); 
        if (($firstYear == $lastYear) && ($firstMonth == $lastMonth)){
            $lastDayMonth = $lastDay;
            
        }        
        $endMonth = date("Y-m-d", strtotime($firstYear.'-'.$firstMonth.'-'.$lastDayMonth));
        
        while (($ate - $de) > 0){
            $de = date("Y-m-d", strtotime($firstYear.'-'.$firstMonth.'-'.$firstDay));
            if (($firstYear >= $lastYear) && ($firstMonth >= $lastMonth) ){
                $lastDayMonth = $lastDay;
                $endMonth = date("Y-m-d", strtotime($firstYear.'-'.$firstMonth.'-'.$lastDayMonth));
                //dd($lastDayMonth);
            }            
            $intervalos[$de] = $endMonth;
            if ($firstMonth < 12){
                $firstMonth += 1;
            } else{
                $firstMonth = 1;
                $firstYear +=1;
            }
            $firstDay = 1;
            $de = date("Ymd", strtotime($firstYear.'-'.$firstMonth.'-'.$firstDay));
            $lastDayMonth = cal_days_in_month(CAL_GREGORIAN, $firstMonth, $firstYear);
            
            $endMonth = date("Y-m-d", strtotime($firstYear.'-'.$firstMonth.'-'.$lastDayMonth));
        }
        return $intervalos;
    }


    public function getPorPeriodo($periodo,$funcionario_id){
        $periodos = $this->separarPeriodos($periodo);
        $funcionario = Funcionario::find($funcionario_id);
        $empresa = 'NSD';
        $cliente = 'FCA';
        $responsavel = '-';
        $lista;
        $cabecalho = ['nome' => $funcionario->nome,
                                'empresa' => $empresa,
                                'cliente' => $cliente,
                                'responsavel' => $responsavel,
                                'de' => $periodo['de'],
                                'ate' => $periodo['ate']
                ];
        foreach ($periodos as $de=>$ate){
            $lista[$de. ' > '. $ate] = DB::table('diariosdebordo')
                    ->where('funcionario_id','=',$funcionario->id)
                    ->where('data', '>=', $de)
                    ->where('data', '<=', $ate)
                    ->get();
//            $lista[$mes]['de']=[$de];
//            $lista[$mes]['ate']=[$ate];
        } 
        $dados['cabecalho']=$cabecalho;
        $dados['infor']=$lista;
        return $dados;
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
    
    //Pega uma string horas 00:00 e converte para um inteiro minutos 
    public function horasToMin($horas){
        $pos1 = strpos($horas, ':');
        $hora= substr($horas, 0,$pos1);
        $min = substr($horas, $pos1+1,$pos1+3);
        $n_horas = intval($hora);
        $n_min = intval($min);
        $n_min += $n_horas * 60;
        return $n_min;
    }
    //converte um inteiro minutos para uma string horas 00:00 
    public function minToHoras($minutos){
        $sinal = (($minutos / 60) < 0) ? '-':'';
        $horas = abs(intval($minutos / 60));
        $min = abs($minutos % 60);
        $minutos_string = $min < 10 ? '0'. $min : $min;
        $horas_string = $horas < 10 ? '0'. $horas : $horas;
        return $sinal . $horas_string . ':' . $minutos_string;
    }
    


    public function getHorasPendentes($data, $horas_deste_lanc = "00:00"){        
        $funcionario = $this->getFuncionarioByUser();
        $horas_lancadas = DB::table('diariosdebordo')
                ->where('funcionario_id','=',$funcionario->id)
                ->where('data','=',$data)
                ->get()->all();
        $today = "08:30";
        
        $n_min = 0;
        if(!empty($horas_lancadas)){
//            dd($horas_lancadas);
            foreach($horas_lancadas as $hl){
                $n_min += $this->horasToMin($hl->n_horas); 
            }
            $min_pendentes = $this->horasToMin($today) - $n_min + $this->horasToMin($horas_deste_lanc);
            $hora = $this->minToHoras($min_pendentes);
            return $hora;
        }  
        return $today;
    }
    
    public function Salvar($request){
        if (!empty($this->id)){  
            $this->fill($request->toArray()); 
            $this->save();   
//            $this->AtualizarPendencia($request); 
            $mensagem = "Diariodebordo ".$this->id." atualizado com sucesso ";
        }else {
            $request['id']=$this->id;
            $this->create($request->toArray());
//            $this->AtualizarPendencia($request);            
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
