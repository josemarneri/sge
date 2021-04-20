<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Despesa;


class DespesaController extends Controller
{
    //
     private $despesa;
    
    public function __construct(Despesa $despesa){
        $this->despesa = $despesa;
    }
    
    public function index(){
        if (Gate::denies('list-despesa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $despesas = $this->despesa->all();
        
        return view('financeiro.despesas.despesas', compact('despesas'));
    }
    
    public function Atualizar($iddespesa){
        $despesa = Despesa::find($iddespesa);
        if (Gate::denies('update-despesa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        return view('financeiro.despesas.novodespesa', compact('despesa'));
    }
    
    public function Novo(){
        if (Gate::denies('create-despesa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $despesa = new Despesa(); 
        $despesa->ativo = true;
        return view('financeiro.despesas.novodespesa', compact('despesa'));
    }
    
   
    
    public function Apagar($iddespesa){
        if (Gate::denies('delete-despesa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $despesa = Despesa::find($iddespesa);        
        $despesa->delete();
        return redirect('/financeiro/despesas');
    }
    
  
    public function Salvar(Request $request){
        $request['ativo'] = empty($request['ativo']) ? false : $request['ativo'];
        if (Gate::denies('save-despesa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (Despesa::find($request->get('id'))){ 
            $despesa = Despesa::find($request->get('id'));            
            $despesa->fill($request->all()); 
            $despesa->save();
            \Session::flash('mensagem_sucesso', "Despesa ".$despesa->nome." atualizada com sucesso ");
        }else {
              $despesa = new Despesa();
              $request['id']=$despesa->id;
              $despesa->create($request->all());
            \Session::flash('mensagem_sucesso', 'Despesa cadastrada com sucesso');
        }  
        return redirect('/financeiro/despesas/novo');
    }
}
