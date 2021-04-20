<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Salario;
use App\Models\Cargo;
use Gate;

class CargoSalarioController extends Controller
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
        $pag = true;
        //$salarios = $this->salario->all()->sortByDesc('id')->paginate(30);
        $filtro;
        $salarios = $this->salario->paginate(30);
        $salario = new Salario();
        $cargos = Cargo::all();
        $comessas = Comessa::all();
        $relatorio = new Relatorio();
        $funcionarios = Funcionario::all();
        $hasPlanilha = $relatorio->existPlanilha();
        return view('financeiro.salarios.salarios', compact('salarios','salario',
                'cargos','hasPlanilha','pag','funcionarios','comessas'));
    }
    
    public function Filtrar(Request $filtro){
        if (Gate::denies('list-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $pag = false;
        $resultado = $this->salario->Filtrar($filtro);
        //dd($resultado);
        $plan = $resultado['all'];
        //$salarios = $resultado['pag'];
        $salarios = $resultado['all'];

        //dd($salarios);
        $salario = new Salario();
        $cargos = Cargo::all(); // Busca a lista de cargos cadastrados
        $comessas = Comessa::all();
        $funcionarios = Funcionario::all(); 
        $relatorio = new Relatorio();
//        $planilha = $relatorio->gerarListaSalariosExcel($plan);               
        $hasPlanilha = $relatorio->existPlanilha();                
        return view('financeiro.salarios.salarios', compact('salarios','salario',
                'hasPlanilha','cargos','pag','funcionarios','comessas'));
    }
    public function BaixarPlanilha(){
        
        $filename = 'Filtro de salarios - '. auth()->user()->name . '.xlsx';
        $file= Storage::disk( 'public')->get($filename);

        return (new Response($file, 200)) 
                ->header('Content-Type', "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    }
    
    public function Atualizar($idsalario){
        $salario = Salario::find($idsalario);
        if (Gate::denies('update-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	} 
        $cargos = Cargo::all();
        $funcionarios = Funcionario::all();
        $comessas = Comessa::all();
        return view('financeiro.salarios.novosalario', compact('salario','cargos','funcionarios','comessas'));
    }
    
    public function Novo(){
        if (Gate::denies('create-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $salario = new Salario();
        $cargos = Cargo::all();
        $funcionarios = Funcionario::all();
        $comessas = Comessa::all();
        return view('financeiro.salarios.novosalario', compact('salario','cargos','funcionarios','comessas'));
    }
    
   
    
    public function Apagar($idsalario){
        if (Gate::denies('delete-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $salario = Salario::find($idsalario);        
        $salario->delete();
        return redirect('/financeiro/salarios');
    }
    
  
    public function Salvar(Request $request){
        $user = auth()->user();

        if (Gate::denies('save-salario')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $salario = Salario::find($request->get('id'));
        if (!empty($salario)){ 
            $salario->fill($request->all()); 
            $salario->save();
            \Session::flash('mensagem_sucesso', "Salario ".$salario->nome." atualizado com sucesso ");
        }else {
              $salario = new Salario();
              $request['id']=$salario->id;              

              $salario->fill($request->all());
              $salario->save();

              
            \Session::flash('mensagem_sucesso', 'Salario cadastrado com sucesso');
        }  
        return redirect('/financeiro/salarios');
    }
}
