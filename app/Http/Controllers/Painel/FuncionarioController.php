<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Funcionario;
use App\Http\Requests\FuncionariosRequest;
use App\Others\PontoExcel;
use App\User;
use App\Models\Cargo;
use App\Models\Funcao;

class FuncionarioController extends Controller
{
    private $funcionario;
    
    public function __construct(Funcionario $funcionario){
        $this->funcionario = $funcionario;
    }
    
    public function index(){
        if (Gate::denies('list-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        //$funcionarios = $this->funcionario->all();
        $funcionarios = $this->funcionario->all()->sortBy('nome');
        
        return view('painel.funcionarios.funcionarios', compact('funcionarios'));
    }
    
    public function Atualizar($idfuncionario){
        $funcionario = Funcionario::find($idfuncionario);
        $users = auth()->user()->all();
        if (Gate::denies('update-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargos = Cargo::all();
        $funcoes = Funcao::all();
        return view('painel.funcionarios.novofuncionario', compact('funcionario','users','cargos','funcoes'));
    }
    
    public function Novo(){
        $users = auth()->user()->all();
        if (Gate::denies('create-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargos = Cargo::all();
        $funcoes = Funcao::all();
        $funcionario = new Funcionario(); 
        
        return view('painel.funcionarios.novofuncionario', compact('funcionario','users','cargos','funcoes'));
    }
    
    public function Apagar($idfuncionario){
        if (Gate::denies('delete-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $funcionario = Funcionario::find($idfuncionario);        
        $funcionario->delete();
        return redirect('/painel/funcionarios');
    }
    
    public function AtivarDesativar($idFuncionario){
        if (Gate::denies('save-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $funcionario = Funcionario::find($idFuncionario);
        $funcionario->ativo = ($funcionario->ativo==1) ? 0 : 1; 
        $funcionario->save();
        return redirect('/painel/funcionarios');
    }
    
    public function Salvar(FuncionariosRequest $request){
        if (Gate::denies('save-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (Funcionario::find($request->get('id'))){ 
            $funcionario = Funcionario::find($request->get('id')); 
            if(empty($request['cargo_id'])){
                 $request['cargo_id'] = null;
              }
              if(empty($request['funcao_id'])){
                 $request['funcao_id'] = null;
              }
            $funcionario->fill($request->all()); 
            $funcionario->save();
            \Session::flash('mensagem_sucesso', "Funcionario ".$funcionario->nome." atualizado com sucesso ");
        }else {
              $funcionario = new Funcionario;
              if(empty($request['cargo_id'])){
                 $request['cargo_id'] = null;
              }
              if(empty($request['funcao_id'])){
                 $request['funcao_id'] = null;
              }
              
              $request['ativo']=true;
              //$request['nome']='Teste';
              //dd($request->all());
              $funcionario->fill($request->all());
              $funcionario->save();
            \Session::flash('mensagem_sucesso', 'Usuario cadastrado com sucesso');
        }  
        return redirect('/painel/funcionarios/novo');
    }
        
    public function AlterarDadosPessoais($id){
        $funcionario = new Funcionario();
        $funcionario = $funcionario->getFuncionarioByUserId($id);
//        if (Gate::denies('change-self', $funcionario)){
//    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
//    	}
        return view('painel.funcionarios.alterardadospessoais', compact('funcionario'));
    }
    
    public function SalvarDadosPessoais(Request $request){
        $id = $request->get('id');
        $funcionario = Funcionario::find($id);
//        if (Gate::denies('change-self', $funcionario)){
//    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
//    	}            
        $funcionario->fill($request->all()); 
        $funcionario->save();
        \Session::flash('mensagem_sucesso', $funcionario->nome.", seus dados foram atualizado com sucesso ");
        return \Redirect::back();
    }

}
