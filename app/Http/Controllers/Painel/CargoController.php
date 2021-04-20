<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Cargo;

class CargoController extends Controller
{
    //
    private $cargo;
    
    public function __construct(Cargo $cargo){
        $this->cargo = $cargo;
    }
    
    public function index(){
        if (Gate::denies('list-cargo')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargos = $this->cargo->all();
        
        return view('painel.cargos.cargos', compact('cargos'));
    }
    
    public function Atualizar($idcargo){
        $cargo = Cargo::find($idcargo);
        if (Gate::denies('update-cargo')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        return view('painel.cargos.novocargo', compact('cargo'));
    }
    
    public function Novo(){
        if (Gate::denies('create-cargo')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargo = new Cargo(); 
        
        return view('painel.cargos.novocargo', compact('cargo'));
    }
    
   
    
    public function Apagar($idcargo){
        if (Gate::denies('delete-cargo')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargo = Cargo::find($idcargo);        
        $cargo->delete();
        return redirect('/painel/cargos');
    }
    
  
    public function Salvar(Request $request){
        if (Gate::denies('save-cargo')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//            dd($request);
        if (Cargo::find($request->get('id'))){ 
            $cargo = Cargo::find($request->get('id'));            
            $cargo->fill($request->all()); 
            $cargo->save();
            \Session::flash('mensagem_sucesso', "Cargo ".$cargo->nome." atualizado com sucesso ");
        }else {
              $cargo = new Cargo();
              $request['id']=$cargo->id;
              $cargo->create($request->all());
            \Session::flash('mensagem_sucesso', 'Cargo cadastrado com sucesso');
        }  
        return redirect('/painel/cargos/novo');
    }
}
