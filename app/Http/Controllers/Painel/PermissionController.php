<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use App\Models\Permission;

class PermissionController extends Controller
{
     //
    private $permissao;
    
    public function __construct(Permission $permissao){
        $this->permissao = $permissao;
    }
    
    public function index(){
        if (Gate::denies('list-permission')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $permissoes = $this->permissao->all();
        
        return view('painel.permissoes.permissoes', compact('permissoes'));
    }
    
    public function Atualizar($id){
        $permissao = Permission::find($id);
        if (Gate::denies('update-permission')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        return view('painel.permissoes.novapermissao', compact('permissao'));
    }
    
    public function Novo(){
        if (Gate::denies('create-permission')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $permissao = new Permission();
        return view('painel.permissoes.novapermissao', compact('permissao'));
    }
    
    public function Apagar($id){
        if (Gate::denies('delete-permission')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $permissao = Permission::find($id);        
        $permissao->delete();
        return redirect('/painel/permissoes');
    }
    
    public function Salvar(Request $request){
        if (Gate::denies('save-permission')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (Permission::find($request->get('id'))){ 
            $permissao = Permission::find($request->get('id'));            
            $permissao->fill($request->all()); 
            $permissao->save();
            \Session::flash('mensagem_sucesso', "Permissão ".$permissao->name." atualizada com sucesso ");
        }else {
              $permissao = new Permission();
              $request['id']= $permissao->id;
              $permissao->create($request->all());
            \Session::flash('mensagem_sucesso', 'Permissão cadastrada com sucesso');
        }  
        return redirect('/painel/permissoes/novo');
    }
}
