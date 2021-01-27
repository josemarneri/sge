<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Gate;
use App\Models\Cliente;

use Illuminate\Http\Request;

class clienteController extends Controller
{
    //
    private $cliente;
    
    public function __construct(Cliente $cliente){
        $this->cliente = $cliente;
    }
    
    public function index(){
        if (Gate::denies('list-cliente')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $clientes = $this->cliente->all();
        
        return view('painel.clientes.clientes', compact('clientes'));
    }
    
    public function Atualizar($idcliente){
        $cliente = Cliente::find($idcliente);
        if (Gate::denies('update-cliente')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        return view('painel.clientes.novocliente', compact('cliente'));
    }
    
    public function Novo(){
        if (Gate::denies('create-cliente')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cliente = new Cliente(); 
        
        return view('painel.clientes.novocliente', compact('cliente'));
    }
    
   
    
    public function Apagar($idcliente){
        if (Gate::denies('delete-cliente')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cliente = Cliente::find($idcliente);        
        $cliente->delete();
        return redirect('/painel/clientes');
    }
    
  
    public function Salvar(Request $request){
        if (Gate::denies('save-cliente')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (Cliente::find($request->get('id'))){ 
            $cliente = Cliente::find($request->get('id'));            
            $cliente->fill($request->all()); 
            $cliente->save();
            \Session::flash('mensagem_sucesso', "Cliente ".$cliente->nome." atualizado com sucesso ");
        }else {
              $cliente = new Cliente();
              $request['id']=$cliente->id;
              $cliente->create($request->all());
            \Session::flash('mensagem_sucesso', 'Cliente cadastrado com sucesso');
        }  
        return redirect('/painel/clientes/novo');
    }
}
