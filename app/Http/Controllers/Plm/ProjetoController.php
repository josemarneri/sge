<?php

namespace App\Http\Controllers\Plm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Projeto;
use App\Models\Comessa;
use Gate;

class ProjetoController extends Controller
{
    //
     private $projeto;
    
    public function __construct(Projeto $projeto){
        $this->projeto = $projeto;
    }
    
    public function index(){
        
        if (Gate::denies('list-projeto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $projetos = $this->projeto->all();
        $projeto = new Projeto();
        
        $comessas = Comessa::all();
        //dd('aqui2');
        return view('plm.projetos.projetos', compact('projetos','projeto','comessas'));
    }
    public function Filtrar(Request $filtro){
        if (Gate::denies('list-projeto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (empty($filtro)){
            $projetos = $this->projeto->all();
        } else {
            $projetos = $this->projeto->Filtrar($filtro);
        }       
        
        //dd($projetos);
        $projeto = new Projeto();
        $comessas = Comessa::all();
        return view('plm.projetos.projetos', compact('projetos','projeto','comessas'));
    }
    
    public function Atualizar($idprojeto){
        $projeto = Projeto::find($idprojeto);
        if (Gate::denies('update-projeto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}        
        $projetos = Projeto::all();
        
        return view('plm.projetos.novoprojeto', compact('projeto', 'projetos'));
    }
    
    public function Novo(){
        if (Gate::denies('create-projeto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $projeto = new Projeto();
        $comessas = Comessa::all();
        
        return view('plm.projetos.novoprojeto', compact('projeto','comessas'));
    }  
    
    public function Apagar($idprojeto){
        if (Gate::denies('delete-projeto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $projeto = Projeto::find($idprojeto);        
        $projeto->delete();
        return redirect('/plm/projetos');
    }
    
  
    public function Salvar(Request $request){
        if (Gate::denies('save-projeto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (Projeto::find($request->get('id'))){ 
            $projeto = Projeto::find($request->get('id'));            
            $projeto->fill($request->all()); 
            $projeto->save();
            \Session::flash('mensagem_sucesso', "Projeto ".$projeto->nome." atualizado com sucesso ");
        }else {
              $projeto = new Projeto();
              $request['id']=$projeto->id;
              $projeto->create($request->all());
            \Session::flash('mensagem_sucesso', 'Projeto cadastrado com sucesso');
        }  
        return redirect('/plm/projetos');
    }
}
