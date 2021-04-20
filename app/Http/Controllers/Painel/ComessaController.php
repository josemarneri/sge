<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use Gate;
use App\Http\Controllers\Controller;
use App\Models\Comessa;
use App\Models\Funcionario;
use App\Models\Orcamento;
use App\Models\Carga;

class ComessaController extends Controller
{
    private $comessa;
    
    public function __construct(Comessa $comessa){
        $this->comessa = $comessa;
    }
    
    public function index(){
        if (Gate::denies('list-comessa')){ 
            $user = auth()->user();
            $coordenador=$user->getFuncionario($user->id);
            $comessas = $this->ListByCoordenador($coordenador);
            if($comessas){
                return view('painel.comessas.comessas', compact('comessas'));
            }
            return view('errors.403');
            
            //abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}else{
            $comessas = $this->comessa->all();
            return view('painel.comessas.comessas', compact('comessas'));
        }
        
    }
    
    public function ListByCoordenador($coordenador){
        if (Gate::denies('list-comessacoordenador',$this->comessa)){
            return false;
    		//abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $comessas = $this->comessa->getByCoordenador($coordenador->id);
        return $comessas;
    }
    
    public function Atualizar($id){
        $comessa = Comessa::find($id);

        if (Gate::denies('update-comessa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//        $df = \DateTime::createFromFormat('Y-m-d', $comessa->data_inicio); 
//        $comessa->data_inicio = $df->format('Y-m-d');
//        $comessa->data_inicio = $comessa->getDataDmyToYmd($comessa->data_inicio);
//        $df = \DateTime::createFromFormat('Y-m-d', $comessa->data_fim); 
//        $comessa->data_fim = $df->format('Y-m-d');

        $funcionario = new Funcionario();
        $gerentes = $funcionario->getByFuncao('gerente');
        $coordenadores = $funcionario->getByFuncao('coordenador','gerente');
        //$coordenadores = $funcionario->all();
        $orcamentos = Orcamento::all();
        $codigo = $comessa->codigo;
        return view('painel.comessas.novacomessa', compact('comessa','gerentes','coordenadores','orcamentos','codigo'));
    }
    
    public function AtivarDesativar($idComessa){
        if (Gate::denies('update-comessa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $comessa = Comessa::find($idComessa);
        $comessa->ativa = ($comessa->ativa==1) ? 0 : 1; 
        $comessa->save();
        return redirect('/painel/comessas');
    }
    
    public function Novo($orcamento_id = 0){
        if (Gate::denies('create-comessa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        
        $comessa = new Comessa(); 
        if($orcamento_id != 0){
            $comessa->orcamento_id = $orcamento_id;
        }
        $data = date('Y-m-d');
        $comessa->data_inicio = $data;
        $comessa->data_fim = $data;
        
        $funcionario = new Funcionario();
        $gerentes = $funcionario->getByFuncao('gerente');
        $coordenadores = $funcionario->getByFuncao('coordenador','gerente');
        //$coordenadores = $funcionario->all(); 
        if(empty($coordenadores)){
            $mensagemErro = "Não existe coordenadores cadastrados no sistema. Sem isso "
                    . "não é possível criar uma nova Comessa!!!";
            return view('errors.10001', compact('mensagemErro'));        
        }
        $orcamentos = Orcamento::all();
        $codigo=null;
        return view('painel.comessas.novacomessa', compact('comessa','gerentes','coordenadores','orcamentos','codigo'));
    }
    
    public function Apagar($id){
        if (Gate::denies('delete-comessa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $comessa = Comessa::find($id);        
        $comessa->delete();
        return redirect('/painel/comessas');
    }
    
    public function Salvar(Request $request){
        $id = $request->get('id');
        $comessa = Comessa::find($id);
        if (Gate::denies('save-comessa')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//        $data = \DateTime::createFromFormat('d/m/Y', $request['data_inicio']);
//        $df = $data->format('Y-m-d');                            
//        $request['data_inicio'] = $df;
        //dd($request['data_fim']);
        //$data = \DateTime::createFromFormat('d/m/Y', $request['data_fim']);
        //$df = $data->format('Y-m-d');                            
        //$request['data_fim'] = $df;
        $request['bloqueio'] = empty($request['bloqueio']) ? 0 : 1;
        if (!empty($comessa)){           
            $comessa->fill($request->all()); 
            $comessa->save();
            \Session::flash('mensagem_sucesso', "Comessa ".$comessa->id." atualizada com sucesso ");
        }else {
            $comessa = new Comessa();
            $request['id']=$comessa->id;
            $request['ativa']=true;
            $comessa->create($request->all());
            \Session::flash('mensagem_sucesso', 'Comessa cadastrada com sucesso');
        }  
        return redirect('/painel/comessas');
    }
    
    public function NovaEquipe($comessa_id){ 
        $comessa = new Comessa();
        $comessa = $comessa->find($comessa_id);
        $carga = new Carga();
        if (Gate::denies('create-equipe',$comessa)){
    		//abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $inclusos = $carga->getByComessa($comessa_id);
        $livres = $carga->getLivres();
        $ocupados = $carga->getOcupados();
        $habilitados = $comessa->getFuncionarios();
        $cargas = $carga->getCargas($comessa->id);
        
        return view('painel.cargas.novaequipe', compact('comessa','inclusos','livres','habilitados','ocupados','cargas'));
    }
    
    public function SalvarEquipe(Request $request){
        $comessa = new Comessa();
        $comessa_id = $request['comessa_id'];
        $comessa = $comessa->find($comessa_id);
        $carga = new Carga();
        if (Gate::denies('save-equipe',$comessa)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}     
        $inclusos = $request['inclusos'];
        $habilitados = $request['habilitados'];
        $exclusos_I = $request['exclusos_I'];
        $equipe_I = $request['equipe_I'];
        $equipe_H = $request['equipe_H'];
        $exclusos_H = $request['exclusos_H'];
        $comessa->limpaEquipe();
        $carga->limpaEquipe($comessa_id);
        $carga->addEquipe($comessa_id, $equipe_I);
        $comessa->addEquipe($comessa_id, $equipe_H);
        $comessa->addEquipe($comessa_id, $equipe_I);
        
        return redirect('/painel/comessas');
    }
    
    public function getCodigo($orcamento_id){  
        $comessa = new Comessa();
        $comessa->codigo = $comessa->getCodigo($orcamento_id);
        return view('painel.comessas.inputCodigo', compact('comessa'));
    }
}
