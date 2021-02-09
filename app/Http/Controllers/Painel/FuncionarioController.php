<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Funcionario;
use App\Http\Requests\FuncionariosRequest;
use App\Others\PontoExcel;
use App\Models\User;
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
        $keepId = $idfuncionario;
        $func = new Funcionario();
        $funcionario = Funcionario::find($idfuncionario);
        if (empty($funcionario)){
            $funcionario = $func->getByNome($Nome);
        }
        $users = auth()->user()->all();
        if (Gate::denies('update-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargos = Cargo::all();
        $funcoes = Funcao::all();
        return view('painel.funcionarios.novofuncionario', compact('funcionario','users','cargos','funcoes','keepId'));
    }
    
    public function Novo(){
        $users = auth()->user()->all();
        if (Gate::denies('create-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargos = Cargo::all();
        $funcoes = Funcao::all();
        $funcionario = new Funcionario();
        $keepId=$funcionario->id;
        
        return view('painel.funcionarios.novofuncionario', compact('funcionario','users','cargos','funcoes','keepId'));
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
        //dd($request);
        if (Gate::denies('save-funcionario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $funcionario = Funcionario::find($request['keepId']);
        if (!empty($funcionario)){ 
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
        $user = User::find($id);
        $funcionario = new Funcionario();
        $funcionario = $funcionario->getFuncionarioByUserId($id);
        if (Gate::denies('update-informacoes', $funcionario)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
            //dd('2');
        return view('painel.funcionarios.alterardadospessoais', compact('funcionario'));
    }
    
    public function SalvarDadosPessoais(Request $request){
        $id = $request->get('id');
        $funcionario = Funcionario::find($id);
        if (Gate::denies('update-informacoes', $funcionario)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}          
        $funcionario->fill($request->all()); 
        $funcionario->save();
        \Session::flash('mensagem_sucesso', $funcionario->nome.", seus dados foram atualizado com sucesso ");
        return \Redirect::back();
    }

}
