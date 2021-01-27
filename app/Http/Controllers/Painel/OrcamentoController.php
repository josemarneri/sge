<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use Gate;
use App\Http\Controllers\Controller;
use App\Models\Orcamento;
use App\Models\Proposta;
use App\Models\Cliente;

class OrcamentoController extends Controller
{
    //
    
    private $orcamento;
    
    public function __construct(Orcamento $orcamento){
        $this->orcamento = $orcamento;
    }
    
    public function index(){
        if (Gate::denies('list-orcamento')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $orcamento = new Orcamento();
        $orcamentos = $this->orcamento->all();
        
        return view('painel.orcamentos.orcamentos', compact('orcamentos'));
    }
    
    public function Atualizar($id){
        $orcamento = Orcamento::find($id);
        if (Gate::denies('update-orcamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}        
        $cliente = new Cliente();
        $clientes = $cliente->all();
        return view('painel.orcamentos.novoorcamento', compact('orcamento','clientes'));
    }
    
    public function Novo(){
        if (Gate::denies('create-orcamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $orcamento = new Orcamento();
        $cliente = new Cliente();
        $clientes = $cliente->all();
        
        return view('painel.orcamentos.novoorcamento', compact('orcamento','clientes'));
    }
    
    public function Apagar($id){
        if (Gate::denies('delete-orcamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $orcamento = Orcamento::find($id);        
        $orcamento->delete();
        return redirect('/painel/orcamentos');
    }
    
    public function Salvar(Request $request){
        if (Gate::denies('save-orcamento')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $id = $request->get('id');
        $orcamento = Orcamento::find($id);
        if (!empty($orcamento)){             
            $orcamento->fill($request->all()); 
            $orcamento->save();
            \Session::flash('mensagem_sucesso', "Orcamento ".$orcamento->id." atualizado com sucesso ");
        }else {
            $orcamento = new Orcamento;
            $request['id']=$orcamento->id;
            $orcamento->create($request->all());
            \Session::flash('mensagem_sucesso', 'Orcamento cadastrado com sucesso');
        }  
        return redirect('/painel/orcamentos/novo');
    }
    
    public function NovaProposta($orcamento_id){
        if (Gate::denies('create-proposta')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $proposta = new Proposta();
        $proposta->orcamento_id = $orcamento_id;
        $data = new \DateTime();
        $proposta->data_envio = $data->format('d/m/Y');
        
        return view('painel.orcamentos.novaproposta', compact('proposta'));
    }
    
    public function AtualizarProposta($id){
        $proposta = Proposta::find($id);
        if (Gate::denies('update-proposta')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $df = \DateTime::createFromFormat('Y-m-d', $proposta->data_envio); 
        $df = $df ? $df->format('d/m/Y') : null;
        $proposta->data_envio = $df;
        
        $df = \DateTime::createFromFormat('Y-m-d', $proposta->data_resposta); 
        $df = $df ? $df->format('d/m/Y') : null;
        $proposta->data_resposta = $df;

        return view('painel.orcamentos.novaproposta', compact('proposta'));
    }
    
    public function VerProposta($id){
        if (Gate::denies('list-proposta')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $proposta = Proposta::find($id);
        $df = \DateTime::createFromFormat('Y-m-d', $proposta->data_envio); 
        $df = $df ? $df->format('d/m/Y') : null;
        $proposta->data_envio = $df;
        
        $df = \DateTime::createFromFormat('Y-m-d', $proposta->data_resposta); 
        $df = $df ? $df->format('d/m/Y') : null;
        $proposta->data_resposta = $df;
        
        return view('painel.orcamentos.verproposta', compact('proposta'));
    }
    
    public function SalvarProposta(Request $request){
        if (Gate::denies('save-proposta')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        //dd($request);
        $id = $request->get('id');
        $proposta = Proposta::find($id);
        if (!empty($proposta)){ 
            $data = \DateTime::createFromFormat('d/m/Y', $request['data_envio']);
            $df = $data ? $data->format('Y-m-d') : $proposta->data_envio;                            
            $request['data_envio'] = $df;
            $data = \DateTime::createFromFormat('d/m/Y', $request['data_resposta']);
            $df = $data ? $data->format('Y-m-d') : $proposta->data_resposta;                            
            $request['data_resposta'] = $df;
            $proposta->fill($request->all());
            $proposta->save();
            \Session::flash('mensagem_sucesso', "Proposta ".$proposta->id." atualizada com sucesso ");
        }else {
              $proposta = new Proposta;
              $request['id']=$proposta->id;
              $df = \DateTime::createFromFormat('d/m/Y', $request['data_envio']);                            
              $df = $df ? $df->format('Y-m-d') : null;
              $request['data_envio'] = $df;
              $df = \DateTime::createFromFormat('d/m/Y', $request['data_resposta']);                            
              $df = $df ? $df->format('Y-m-d') : null;
              $request['data_resposta'] = $df;
              $proposta->create($request->all());
              //dd($proposta);
            \Session::flash('mensagem_sucesso', 'Proposta cadastrada com sucesso');
        }  
        return redirect('/painel/orcamentos');
    }
}
