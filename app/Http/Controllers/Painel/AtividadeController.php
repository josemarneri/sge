<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Request as RF;
use App\Models\Atividade;
use App\Models\Comessa;
use App\Models\Checklist;
use App\Models\Funcionario;

class AtividadeController extends Controller
{
    private $atividade;
    
    public function __construct(Atividade $atividade){
        $this->atividade = $atividade;
    }
    
    public function index(){
        if (Gate::denies('list-atividade')){ 
            $user = auth()->user();
            $atividades = $this->atividade->getByUser($user);
                return view('painel.atividades.atividades', compact('atividades'));
    	}
        $atividades = $this->atividade->all();
        return view('painel.atividades.atividades', compact('atividades'));
    }
    
    public function Atualizar($id){
        $atividade = Atividade::find($id);
        if (Gate::denies('update-atividade',$atividade)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        //$atividade->prev_inicio = $this->atividade->formatDateToDMY($atividade->prev_inicio);
        //$atividade->prev_fim = $this->atividade->formatDateToDMY($atividade->prev_fim);
        $comessa = Comessa::find($atividade->comessa_id);
        $funcionarios = $comessa->getFuncionarios();
        $funcionario = new Funcionario();
        //$funcionarios = $funcionario->all();
        $coordenadores = $funcionario->all();
        //$coordenador = $coordenador->getFuncionarioByUserId(auth()->user()->id);
        //$comessas = $comessa->getByCoordenador($coordenador->id);
        $comessas = Comessa::all();
        $checklists = Checklist::all();
        $anexos = $atividade->getAnexos();
        return view('painel.atividades.novaatividade', 
                compact('atividade','funcionarios','anexos','coordenadores','comessas','checklists'));
    }
    
    public function Novo($comessa_id = 0){
        $atividade = new Atividade(); 
        $comessa = new Comessa();
        if($comessa_id != 0){
            $atividade->comessa_id = $comessa_id;
            $comessa = Comessa::find($comessa_id);
        }
        if (Gate::denies('create-atividade',$atividade)){            
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}      
        
        $data = date('Y-m-d');
        $atividade->prev_inicio = $data;
        $atividade->prev_fim = $data;
        //$funcionarios = $comessa->getFuncionarios();
        
        $funcionario = new Funcionario();
        $funcionarios = $funcionario->all();
        $coordenadores = $funcionario->all();
        $funcionario = $funcionario->getFuncionarioByUserId(auth()->user()->id);
        //$comessas = $comessa->getByCoordenador($coordenador->id);
        $comessas = $comessa->all();
        $checklists = Checklist::all();
        $anexos = $this->atividade->getAnexos();
        return view('painel.atividades.novaatividade', 
                compact('atividade','funcionarios','anexos','coordenadores','comessas','checklists'));
    }
    
    public function getFuncionarios($comessa_id){
        
        $comessa = Comessa::find($comessa_id);
        $funcionarios = $comessa->getFuncionarios();
        return view('painel.atividades.selectfuncionario', compact('funcionarios'));
    }
    
    public function Apagar($id){        
        if (Gate::denies('delete-atividade')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $atividade = $this->atividade->find($id);        
        $atividade->delete();
        return redirect('/painel/atividades');
    }
    
    public function Salvar(Request $request){
        $id = $request->get('id');
        $atividade = Atividade::find($id);
        if (empty($id)){
            $atividade = new Atividade();
            $atividade->comessa_id = $request['comessa_id'];
        }
        
        if (Gate::denies('save-atividade',$atividade)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//        $request['prev_inicio'] = $this->atividade->formatDateToYMD($request['prev_inicio']);                           
//        $request['prev_fim'] = $this->atividade->formatDateToYMD($request['prev_fim']);
        $request['status'] = 'Aguardando'; 
        if (!empty($id)){  
            $atividade->fill($request->all()); 
            $atividade->save();
            \Session::flash('mensagem_sucesso', "Atividade ".$atividade->id." atualizada com sucesso ");
        }else {            
            $request['id']=$atividade->id;
            $atividade->id = $atividade->Salvar($request->all());
            \Session::flash('mensagem_sucesso', 'Atividade cadastrada com sucesso');
        }
        $atividade->limpaChecklists();
        $atividade->addChecklists($request['checklists_id']);
        return redirect('/painel/atividades/atualizar/'. $atividade->id);
    }
    
    public function Iniciar($id){
        $atividade = $this->atividade->find($id);
        if (Gate::denies('executar-atividade',$atividade)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $data = new \DateTime();
        $atividade->data_inicio = $data->format('d/m/Y');
        $atividade->status = 'Em andamento';
        $atividade->save();
        return redirect()->back();
    }
    
    public function Concluir(Request $request, $id){
        $atividade = $this->atividade->find($id);
        if (Gate::denies('executar-atividade',$atividade)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $data = new \DateTime();
        $atividade->data_fim = $data->format('d/m/Y');
        $atividade->status = 'Concluída';
        $atividade->obsconclusao = $request['obsconclusao'];
        $atividade->save();
        return redirect()->back();
    }
    
    public function addNota(Request $request, $id){
        $atividade = $this->atividade->find($id);
        if (Gate::denies('executar-atividade',$atividade)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $atividade->obsconclusao .= $request['obsconclusao'];
        $atividade->save();
        return redirect()->back();
    }
    
    public function Avaliar(Request $request, $id){
       $atividade = $this->atividade->find($id);
        if (Gate::denies('avaliar-atividade',$atividade)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $atividade->status = $request('status');
        $atividade->avaliacao = $request('avaliacao');
        $atividade->obsresponsavel = $request['obsresponsavel'];
        $atividade->save();
        return redirect()->back(); 
    }
}
