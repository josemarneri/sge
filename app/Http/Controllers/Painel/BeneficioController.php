<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Beneficio;
use App\Models\Cargo;
use App\Models\Funcionario;

class BeneficioController extends Controller
{
    //
    private $beneficio;
    
    public function __construct(Beneficio $beneficio){
        $this->beneficio = $beneficio;
    }
    
    public function index(){
        if (Gate::denies('list-beneficio')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $beneficios = $this->beneficio->all();
        $beneficio = new Beneficio();
        return view('painel.beneficios.beneficios', compact('beneficios','beneficio'));
    }
    
    public function Atualizar($idbeneficio){
        $beneficio = Beneficio::find($idbeneficio);
        if (Gate::denies('update-beneficio')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        return view('painel.beneficios.novobeneficio', compact('beneficio'));
    }
    
    public function Novo(){
        if (Gate::denies('create-beneficio')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $beneficio = new Beneficio(); 
        $beneficio->ativo = true;
        $beneficio->valor = 0;
        $beneficio->percentual = 0;
        return view('painel.beneficios.novobeneficio', compact('beneficio'));
    }
    
   
    
    public function Apagar($idbeneficio){
        if (Gate::denies('delete-beneficio')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $beneficio = Beneficio::find($idbeneficio);        
        $beneficio->delete();
        return redirect('/painel/beneficios');
    }
    
  
    public function Salvar(Request $request){                
        $request['ativo'] = empty($request['ativo']) ? false : $request['ativo'];
        
        if (Gate::denies('save-beneficio')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
//            dd($request);
        if (Beneficio::find($request->get('id'))){ 
            $beneficio = Beneficio::find($request->get('id'));            
            $beneficio->fill($request->all()); 
            $beneficio->save();
            \Session::flash('mensagem_sucesso', "Beneficio ".$beneficio->nome." atualizado com sucesso ");
        }else {
            $beneficio = new Beneficio();
            $request['id']=$beneficio->id;
              $beneficio = $beneficio->create($request->all());
            \Session::flash('mensagem_sucesso', 'Beneficio cadastrado com sucesso');
        }
//        dd($request);
        
        return redirect('/painel/beneficios/novo');
    }
    
    public function NovosBeneficiados($beneficio_id){ 
        $beneficio = new Beneficio();
        $beneficio = $beneficio->find($beneficio_id);
        $funcionarios = Funcionario::all();
        if (Gate::denies('create-beneficio',$beneficio)){
    		//abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        
        return view('painel.beneficios.novosbeneficiados', compact('beneficio','funcionarios'));
    }
    
    public function SalvarBeneficiados(Request $request){
        $beneficio = new Beneficio();
        $beneficio_id = $request['beneficio_id'];
        $beneficio = $beneficio->find($beneficio_id);

        if (Gate::denies('save-beneficio',$beneficio)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}     
        $inclusos = $request['inclusos'];

        $beneficio->limparBeneficiados();
        $beneficio->addBeneficiados($inclusos);
        
        return redirect('/painel/beneficios');
    }
    
    public function AtivarDesativar($idBeneficio){
        if (Gate::denies('update-beneficio')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $beneficio = Beneficio::find($idBeneficio);
        $beneficio->ativo = ($beneficio->ativo==1) ? 0 : 1; 
        $beneficio->save();
        return redirect('/painel/beneficios');
    }
}
