<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Diariodebordo;
use App\Models\Comessa;
use Gate;
use Hamcrest\Type\IsDouble;

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
//        dd($horas_pendentes,$horas);
        //$diariodebordo->data = $this->diariodebordo->formatDateToDMY($diariodebordo->data);
        $comessas = $diariodebordo->getComessas();
        $atividades = $diariodebordo->getAtividades($diariodebordo->comessa_id);
        $diariosdebordo = $this->diariodebordo->getByUser();     
        return view('painel.diariosdebordo.listdiariosdebordo', 
                compact('diariodebordo','horas_pendentes','comessas','diariosdebordo', 'atividades','horas'));
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
        $horas = "00:00";
        $horas_pendentes = $diariodebordo->getHorasPendentes($diariodebordo->data);
        
        $comessas = $diariodebordo->getComessas();
        $diariosdebordo = $this->diariodebordo->getByUser(); 
        //dd($diariosdebordo);
        return view('painel.diariosdebordo.listdiariosdebordo', 
                compact('diariodebordo','horas_pendentes','comessas','diariosdebordo','horas'));
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
