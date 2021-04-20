<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Fornecedor;


class FornecedorController extends Controller
{
     //
    public function __construct(Fornecedor $fornecedor){
        $this->fornecedor = $fornecedor;
    }
    
    public function index(){
        if (Gate::denies('list-fornecedor')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $fornecedores = $this->fornecedor->all();
        
        return view('painel.fornecedores.fornecedores', compact('fornecedores'));
    }
    
    public function Atualizar($idfornecedor){
        $fornecedor = Fornecedor::find($idfornecedor);
        if (Gate::denies('update-fornecedor')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        return view('painel.fornecedores.novofornecedor', compact('fornecedor'));
    }
    
    public function Novo(){
        if (Gate::denies('create-fornecedor')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $fornecedor = new Fornecedor(); 
        
        return view('painel.fornecedores.novofornecedor', compact('fornecedor'));
    }
    
   
    
    public function Apagar($idfornecedor){
        if (Gate::denies('delete-fornecedor')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $fornecedor = Fornecedor::find($idfornecedor);        
        $fornecedor->delete();
        return redirect('/painel/fornecedores');
    }
    
  
    public function Salvar(Request $request){
        if (Gate::denies('save-fornecedor')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (Fornecedor::find($request->get('id'))){ 
            $fornecedor = Fornecedor::find($request->get('id'));            
            $fornecedor->fill($request->all()); 
            $fornecedor->save();
            \Session::flash('mensagem_sucesso', "Fornecedor ".$fornecedor->nome." atualizado com sucesso ");
        }else {
              $fornecedor = new Fornecedor();
              $request['id']=$fornecedor->id;
              $fornecedor->create($request->all());
            \Session::flash('mensagem_sucesso', 'Fornecedor cadastrado com sucesso');
        }  
        return redirect('/painel/fornecedores/novo');
    }
}
