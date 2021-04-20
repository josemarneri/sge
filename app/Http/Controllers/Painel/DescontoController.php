<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Desconto;
use App\Models\Cargo;
use App\Models\Funcionario;

class DescontoController extends Controller
{
    
    private $desconto;
    
    public function __construct(Desconto $desconto){
        $this->desconto = $desconto;
    }
    
    public function index(){
        if (Gate::denies('list-desconto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $descontos = $this->desconto->all();
        $desconto = new Desconto();
        return view('painel.descontos.descontos', compact('descontos','desconto'));
    }
    
    public function Atualizar($iddesconto){
        $desconto = Desconto::find($iddesconto);
        if (Gate::denies('update-desconto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        return view('painel.descontos.novodesconto', compact('desconto'));
    }
    
    public function Novo(){
        if (Gate::denies('create-desconto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $desconto = new Desconto(); 
        $desconto->ativo = true;
        $desconto->valor = 0;
        $desconto->percentual = 0;
        return view('painel.descontos.novodesconto', compact('desconto'));
    }
    
   
    
    public function Apagar($iddesconto){
        if (Gate::denies('delete-desconto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $desconto = Desconto::find($iddesconto);        
        $desconto->delete();
        return redirect('/painel/descontos');
    }
    
  
    public function Salvar(Request $request){                
        $request['ativo'] = empty($request['ativo']) ? false : $request['ativo'];
        
        if (Gate::denies('save-desconto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//            dd($request);
        if (Desconto::find($request->get('id'))){ 
            $desconto = Desconto::find($request->get('id'));            
            $desconto->fill($request->all()); 
            $desconto->save();
            \Session::flash('mensagem_sucesso', "Desconto ".$desconto->nome." atualizado com sucesso ");
        }else {
            $desconto = new Desconto();
            $request['id']=$desconto->id;
              $desconto = $desconto->create($request->all());
            \Session::flash('mensagem_sucesso', 'Desconto cadastrado com sucesso');
        }
//        dd($request);
        
        return redirect('/painel/descontos/novo');
    }
    
    public function NovosDescontados($desconto_id){ 
        $desconto = new Desconto();
        $desconto = $desconto->find($desconto_id);
        $funcionarios = Funcionario::all();
        if (Gate::denies('create-desconto',$desconto)){
    		//abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        
        return view('painel.descontos.novosdescontados', compact('desconto','funcionarios'));
    }
    
    public function SalvarDescontados(Request $request){
        $desconto = new Desconto();
        $desconto_id = $request['desconto_id'];
        $desconto = $desconto->find($desconto_id);

        if (Gate::denies('save-desconto',$desconto)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}     
        $inclusos = $request['inclusos'];

        $desconto->limparDescontados();
        $desconto->addDescontados($inclusos);
        
        return redirect('/painel/descontos');
    }
    
    public function AtivarDesativar($idDesconto){
        if (Gate::denies('update-desconto')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $desconto = Desconto::find($idDesconto);
        $desconto->ativo = ($desconto->ativo==1) ? 0 : 1; 
        $desconto->save();
        return redirect('/painel/descontos');
    }
}
