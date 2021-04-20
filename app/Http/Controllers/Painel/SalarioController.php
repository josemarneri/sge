<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Salario;
use App\Models\Cargo;

class SalarioController extends Controller
{
    //
    private $salario;
    
    public function __construct(Salario $salario){
        $this->salario = $salario;
    }
    
    public function index(){
        if (Gate::denies('list-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $salarios = $this->salario->all();
        $salario = new Salario();
        return view('painel.salarios.salarios', compact('salarios','salario'));
    }
    
    public function Atualizar($idsalario){
        $salario = Salario::find($idsalario);
        if (Gate::denies('update-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargos = Cargo::all();
        return view('painel.salarios.novosalario', compact('salario','cargos'));
    }
    
    public function Novo(){
        if (Gate::denies('create-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $salario = new Salario(); 
        $cargos = Cargo::all();
        $salario->ativo = true;
        return view('painel.salarios.novosalario', compact('salario','cargos'));
    }
    
   
    
    public function Apagar($idsalario){
        if (Gate::denies('delete-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $salario = Salario::find($idsalario);        
        $salario->delete();
        return redirect('/painel/salarios');
    }
    
  
    public function Salvar(Request $request){
        $request['ativo'] = empty($request['ativo']) ? false : $request['ativo'];
        $request['valor_mensal'] = empty($request['valor_mensal']) ? 0 : $request['valor_mensal'];
        $request['valor_hora'] = empty($request['valor_hora']) ? 0 : $request['valor_hora'];
        
        if (Gate::denies('save-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//            dd($request);
        if (Salario::find($request->get('id'))){ 
            $salario = Salario::find($request->get('id'));            
            $salario->fill($request->all()); 
            $salario->save();
            \Session::flash('mensagem_sucesso', "Salario ".$salario->nome." atualizado com sucesso ");
        }else {
            $salario = new Salario();
            $salario->salvarCargo($request);
            \Session::flash('mensagem_sucesso', 'Salario cadastrado com sucesso');
        }
//        dd($request);
        
        return redirect('/painel/salarios/novo');
    }
}
