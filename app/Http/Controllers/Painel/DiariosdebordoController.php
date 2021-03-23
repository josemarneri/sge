<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Diariodebordo;
use App\Models\Comessa;
use Gate;
use Hamcrest\Type\IsDouble;
use App\Models\Others\Math;

class DiariosdebordoController extends Controller
{
    private $diariodebordo;
    
    public function __construct(Diariodebordo $diariodebordo){
        $this->diariodebordo = $diariodebordo;
    }
    
    public function index(){
        return redirect('/painel/diariosdebordo/novo');
    }
    
    public function Atualizar($id){
        $diariodebordo = Diariodebordo::find($id);
        if (Gate::denies('update-diariodebordo',$diariodebordo)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        //$data = $this->diariodebordo->formatDateToDMY($diariodebordo->data);
        //dd($diariodebordo);
        $data = $diariodebordo->data;
        $horas = $diariodebordo->n_horas;
        $horas_pendentes = $diariodebordo->getHorasPendentes($diariodebordo->data,$horas);
        $descricao = $diariodebordo->descricao;
        $comessas = $diariodebordo->getComessas();
        $atividades = $diariodebordo->getAtividades($diariodebordo->comessa_id);
        $diariosdebordo = $this->diariodebordo->getByUser();  
//        dd($diariodebordo->data);
        return view('painel.diariosdebordo.listdiariosdebordo', 
                compact('diariodebordo','horas_pendentes','comessas','diariosdebordo', 'atividades','horas', 'descricao'));
    }
    
    public function Novo($comessa_id = 0){
        $diariodebordo = new Diariodebordo();
        if($comessa_id != 0){
            $diariodebordo->comessa_id = $comessa_id;
        }
        if (Gate::denies('create-diariodebordo',$diariodebordo)){            
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $diariodebordo->data = date("Y-m-d");
        $horas = "08:30";
        $diariodebordo->n_horas = $horas;
        $horas_pendentes = $diariodebordo->getHorasPendentes($diariodebordo->data);
        
        $comessas = $diariodebordo->getComessas();
        $diariosdebordo = $this->diariodebordo->getByUser();
        $descricao='';
        //dd($diariosdebordo);
        return view('painel.diariosdebordo.listdiariosdebordo', 
                compact('diariodebordo','horas_pendentes','comessas','diariosdebordo','horas', 'descricao'));
    }
    
    public function getAtividades($comessa_id){        
        $comessa = Comessa::find($comessa_id);        
        $atividades = $this->diariodebordo->getAtividades($comessa_id);        
        
        return view('painel.diariosdebordo.selectatividades', compact('atividades'));
    }
    
    public function getDescricao($comessa_id){        
        $comessa = Comessa::find($comessa_id);
        $descricao = $comessa->descricao;         
        $atividades = $this->diariodebordo->getAtividades($comessa_id);        
         if (!empty($atividades)){
            $descricao .= ' - '. $atividades[0]->titulo;
        }
        return view('painel.diariosdebordo.preencherdescricao', compact('atividades','descricao'));
    }
    
    public function getDescricaoAtividade($atividade_id){ 
        dd('22222');
        $atividade = Atividade::find($atividade_id);
        dd('22222');
        $comessa = Comessa::find($atividade->comessa_id);
        
        $descricao = ' - '. $atividade->titulo;
        dd($descricao);
        return view('painel.diariosdebordo.preencherdescricao', compact('descricao'));
    }
    
    public function getHorasPendentes($data){
        $horas = $this->diariodebordo->getHorasPendentes($data); 
        return view('painel.diariosdebordo.horaspendentes', compact('horas'));
    }
    
    public function Apagar($id){        
        if (Gate::denies('delete-diariodebordo')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $diariodebordo = $this->diariodebordo->find($id);  
        //$request['data'] = $diariodebordo->data;
        //$request['n_horas'] = $diariodebordo->n_horas;
        //$request['horas_pendentes'] = 0;
        //$diariodebordo->AtualizarPendencia($request);        
        $diariodebordo->delete();
        return redirect('/painel/diariosdebordo');
    }
    
    public function Salvar(Request $request){
        $id = $request->get('id');
        $diariodebordo = Diariodebordo::find($id);
        if(empty($id)){
            $diariodebordo = new Diariodebordo();
            $ddb = $diariodebordo->getDDB($request);
            if (empty($ddb)){
                $diariodebordo = new Diariodebordo();
            }else{
                $diariodebordo = Diariodebordo::find($ddb->id);
                $math = new Math();
                $request['n_horas'] = $math->somaHoras($request['n_horas'], $ddb->n_horas);
                $request['id'] = $ddb->id;
                }
            //dd(1);
            $diariodebordo->funcionario_id = $request['funcionario_id'];
            //dd(2);
        }
        
        if (Gate::denies('save-diariodebordo',$diariodebordo)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        
        
        
        if (!empty($id)){ 
            $diariodebordo->fill($request->all());
            $diariodebordo->save();
            \Session::flash('mensagem_sucesso', " Diario de bordo atualizado com sucesso ");
        }else {
            $diariodebordo->fill($request->all());
            $diariodebordo->save();
            \Session::flash('mensagem_sucesso', " Diario de bordo inserido com sucesso ");
        }  
        
        
//        \Session::flash('mensagem_sucesso',$diariodebordo->Salvar($request));
        
        return redirect('/painel/diariosdebordo/novo/');
    }
}
