<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use App\Models\Checklist;
use App\Models\Pergunta;
use App\Models\RespostaChecklist;

class ChecklistController extends Controller
{
    //
    private $checklist;
    
    public function __construct(Checklist $checklist){
        $this->checklist = $checklist;
    }
    
    public function index(){
        if (Gate::denies('list-checklist')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $checklists = $this->checklist->all();
        return view('painel.checklists.checklists', compact('checklists'));
    }
    
    public function Novo(){
        if (Gate::denies('create-checklist')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}        
        $checklist = new Checklist();
        return view('painel.checklists.novochecklist', compact('checklist'));
    }

    public function Atualizar($id){
        $checklist = Checklist::find($id);
        if (Gate::denies('update-checklist')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $perguntas = $checklist->getPerguntas();
        return view('painel.checklists.novochecklist', compact('checklist','perguntas'));
    }

    public function Apagar($id){
        if (Gate::denies('delete-checklist')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $checklist = Checklist::find($id);        
        $checklist->delete();
        return redirect('/painel/checklists');
    }
    
    public function ApagarPergunta($id){
        if (Gate::denies('delete-checklist')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $pergunta = Pergunta::find($id);
        $pergunta->delete();
        return redirect()->back();
    }
    
    public function Salvar(Request $request){
        $id = $request->get('id');
        $checklist = Checklist::find($id);
        if (Gate::denies('save-checklist')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}        
        if (!empty($checklist)){           
            $checklist->fill($request->all()); 
            $checklist->save();
            \Session::flash('mensagem_sucesso', "Checklist ".$checklist->id." atualizado com sucesso ");
        }else {
            $checklist = new Checklist();
            $request['id']=$checklist->id;
            $checklist->create($request->all());
            \Session::flash('mensagem_sucesso', 'Checklist cadastrado com sucesso');
        } 
        $checklist = $this->checklist->getByName($request['nome']);
        $perguntasnovas = $request['perguntasnovas'];
        $checklist->addPerguntas($perguntasnovas);
        return redirect('/painel/checklists');
    }
    
}
