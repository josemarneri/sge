<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Carga;
use App\Models\Funcionario;
use Gate;
use App\Models\Comessa;

class CargaController extends Controller
{
    //
    private $carga;
    
    public function __construct(Carga $carga){
        $this->carga = $carga;
    }
    
    public function index(){
        if (Gate::denies('list-carga')){
            $user = auth()->user();
            $coordenador=$user->getFuncionario($user->id);
            $cargas = $this->ListByCoordenador($coordenador->id);
            if($cargas){
                return view('painel.cargas.cargas', compact('cargas'));
            }else{
                return view('errors.403');
            }
            //abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}else{
            $cargas = $this->carga->all();
            return view('painel.cargas.cargas', compact('cargas'));
        }
    }
    
    public function ListByCoordenador($coordenador_id){
        $coordenador = Funcionario::find($coordenador_id);
        if (Gate::denies('list-carga',$coordenador)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $cargas = $this->carga->getCargaByCoordenador($coordenador_id);
        return view('painel.cargas.cargas', compact('cargas'));
    }
    
    public function Livre($id){
        $carga = Carga::find($id);
        $funcionarios_id[]=$carga->funcionario_id;
        $comessa = new Comessa();
        if (Gate::denies('update-carga',$carga)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if($carga->livre==1){
            $carga->livre = 0;            
        }else{
            $carga->livre = 1;
            $comessa->addEquipe($carga->comessa_id, $funcionarios_id);
        }

        $carga->save();
        return redirect('/painel/cargas');
    }
    public function Atualizar($id){
        $carga = Carga::find($id);
        if (Gate::denies('update-carga', $carga)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//        $df = \DateTime::createFromFormat('Y-m-d', $carga->data_inicio); 
//        $carga->data_inicio = $df->format('d/m/Y');
//        $df = \DateTime::createFromFormat('Y-m-d', $carga->data_fim); 
//        $carga->data_fim = $df ? $df->format('d/m/Y'):null;
        $comessas = Comessa::all();
        return view('painel.cargas.novacarga', compact('carga','comessas'));
    }
    
    public function Novo(){
        if (Gate::denies('create-carga')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}        
        $carga = new Carga(); 
        $data = date('Y-m-d');
        $carga->data_inicio = $data;
        $carga->data_fim = $data;        
        $funcionarios = $this->carga->getFuncionarioSemCarga();
        $comessas = Comessa::all();
        return view('painel.cargas.novacarga', compact('carga','funcionarios','comessas'));
    }
    
    public function Apagar($id){
        if (Gate::denies('delete-carga')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $carga = Carga::find($id);        
        $carga->delete();
        return redirect('/painel/cargas');
    }
    
    public function Salvar(Request $request){
        $id = $request->get('id');
        $funcionarios_id[]=$request->get('funcionario_id');
        $comessa_id=$request->get('comessa_id');
        $comessa = new Comessa();
        $carga = Carga::find($id);
        if (Gate::denies('save-carga',$carga)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//        $data = \DateTime::createFromFormat('d/m/Y', $request['data_inicio']);
//        $df = $data->format('Y-m-d');                            
//        $request['data_inicio'] = $df;
//        $data = \DateTime::createFromFormat('d/m/Y', $request['data_fim']);
//        $df = $data->format('Y-m-d');                            
//        $request['data_fim'] = $df;
        $request['livre'] = empty($request['livre']) ? 0 : 1;
        
        if (!Empty($carga)){            
            $carga->fill($request->all()); 
            $carga->save();           
            \Session::flash('mensagem_sucesso', "Carga ".$carga->id." atualizada com sucesso ");
        }else {
            $carga = new Carga();
            $request['id']=$carga->id;
            $carga->create($request->all());            
            \Session::flash('mensagem_sucesso', 'Carga cadastrada com sucesso');
        } 
        $comessa->addEquipe($comessa_id, $funcionarios_id);
        return redirect('/painel/cargas');
    }
    
    
}
