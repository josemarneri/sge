<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Diariodebordo;
use App\Models\Comessa;
use Gate;

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
        $data = $this->diariodebordo->formatDateToDMY($diariodebordo->data);
        $pendencias[$data] = $diariodebordo->data;
        $lanc_pendentes = $pendencias;
        $horas = $this->diariodebordo->getHorasPendentes($diariodebordo->data) + $diariodebordo->n_horas;
        $diariodebordo->data = $this->diariodebordo->formatDateToDMY($diariodebordo->data);
        $comessas = $diariodebordo->getComessas();
        $atividades = $diariodebordo->getAtividades($diariodebordo->comessa_id);
        $diariosdebordo = $this->diariodebordo->getByUser();     
        return view('painel.diariosdebordo.listdiariosdebordo', 
                compact('diariodebordo','lanc_pendentes','comessas','diariosdebordo', 'atividades','horas'));
    }
    
    public function Novo($comessa_id = 0){
        $diariodebordo = new Diariodebordo(); 
        if($comessa_id != 0){
            $diariodebordo->comessa_id = $comessa_id;
        }
        if (Gate::denies('create-diariodebordo',$diariodebordo)){            
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $lanc_pendentes = $this->diariodebordo->getLancamentosPendetes();
        
        if(empty($lanc_pendentes)){
            $lanc_pendentes=null;
            $horas = null;
        }else{
           $horas = $this->diariodebordo->getHorasPendentes(pos($lanc_pendentes)); 
        }
        $comessas = $diariodebordo->getComessas();
        $diariosdebordo = $this->diariodebordo->getByUser();                
        return view('painel.diariosdebordo.listdiariosdebordo', 
                compact('diariodebordo','lanc_pendentes','comessas','diariosdebordo','horas'));
    }
    
    public function getAtividades($comessa_id){
        $atividades = $this->diariodebordo->getAtividades($comessa_id);
        return view('painel.diariosdebordo.selectatividades', compact('atividades'));
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
        $request['data'] = $diariodebordo->data;
        $request['n_horas'] = $diariodebordo->n_horas;
        $request['horas_pendentes'] = 0;
        $diariodebordo->AtualizarPendencia($request);        
        $diariodebordo->delete();
        return redirect('/painel/diariosdebordo');
    }
    
    public function Salvar(Request $request){
        $id = $request->get('id');
        $diariodebordo = Diariodebordo::find($id);
        if(empty($id)){
            $diariodebordo = new Diariodebordo();
            $diariodebordo->funcionario_id = $request['funcionario_id'];
        }
        
        if (Gate::denies('save-diariodebordo',$diariodebordo)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        
        \Session::flash('mensagem_sucesso',
                $diariodebordo->Salvar($request));
        
        return redirect('/painel/diariosdebordo/novo/');
    }
}
