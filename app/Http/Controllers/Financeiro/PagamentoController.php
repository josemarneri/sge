<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Models\Despesa;
use App\Models\Comessa;
use App\Models\Relatorio;
use App\Models\Funcionario;
use App\Models\Diariodebordo;
use Gate;

class PagamentoController extends Controller
{
    //
    private $pagamento;
    
    public function __construct(Pagamento $pagamento){
        $this->pagamento = $pagamento;
    }
    
    public function index(){
        if (Gate::denies('list-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $pag = true;
        //$pagamentos = $this->pagamento->all()->sortByDesc('id')->paginate(30);
        $filtro=null;
        $resultado = $this->pagamento->Filtrar($filtro);
        $pagamentos = $resultado['pag'];
        $pagamento = new Pagamento();
        $despesas = Despesa::all();
        $comessas = Comessa::all();
        $relatorio = new Relatorio();
        $funcionarios = Funcionario::all();
        $hasPlanilha = $relatorio->existPlanilha();
        return view('financeiro.pagamentos.pagamentos', compact('pagamentos','pagamento',
                'despesas','hasPlanilha','pag','funcionarios','comessas'));
    }
    
    public function Filtrar(Request $filtro){
        if (Gate::denies('list-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $pag = false;
        $resultado = $this->pagamento->Filtrar($filtro);
        //dd($resultado);
        $plan = $resultado['all'];
        //$pagamentos = $resultado['pag'];
        $pagamentos = $resultado['all'];

        //dd($pagamentos);
        $pagamento = new Pagamento();
        $despesas = Despesa::all(); // Busca a lista de despesas cadastrados
        $comessas = Comessa::all();
        $funcionarios = Funcionario::all(); 
        $relatorio = new Relatorio();
//        $planilha = $relatorio->gerarListaPagamentosExcel($plan);               
        $hasPlanilha = $relatorio->existPlanilha();                
        return view('financeiro.pagamentos.pagamentos', compact('pagamentos','pagamento',
                'hasPlanilha','despesas','pag','funcionarios','comessas'));
    }
    public function BaixarPlanilha(){
        
        $filename = 'Filtro de pagamentos - '. auth()->user()->name . '.xlsx';
        $file= Storage::disk( 'public')->get($filename);

        return (new Response($file, 200)) 
                ->header('Content-Type', "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    }
    
    public function Atualizar($idpagamento){
        $pagamento = Pagamento::find($idpagamento);
        if (Gate::denies('update-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	} 
        $despesas = Despesa::all();
        $funcionarios = Funcionario::all();
        $comessas = Comessa::all();
        return view('financeiro.pagamentos.novopagamento', compact('pagamento','despesas','funcionarios','comessas'));
    }
    
    public function Novo(){
        if (Gate::denies('create-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $pagamento = new Pagamento();
        $despesa = new Despesa();
        $despesas = $despesa->all();
        $funcionarios = Funcionario::all();
        $comessas = Comessa::all();
        return view('financeiro.pagamentos.novopagamento', compact('pagamento','despesas','funcionarios','comessas'));
    }
    public function AtualizarSalario($idpagamento){
        $pagamento = Pagamento::find($idpagamento);
        if (Gate::denies('update-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	} 
        $despesa = new Despesa();
        $despesas[] = $despesa->getByNome('Salario');
        $funcionarios = Funcionario::all();
        $comessas = Comessa::all();
        return view('financeiro.pagamentos.novopagamentosalario', compact('pagamento','despesas','funcionarios','comessas'));
    }
    
    public function NovoSalario(){
        $relatorio = new Relatorio();
        if (Gate::denies('create-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $data = date('Y-m-d');
        $periodo = $relatorio->getPeriodoMesAnterior($data);
        $data_inicio = $periodo['de'];
        $data_fim = $periodo['ate'];
        $pagamento = new Pagamento();
        $despesa = new Despesa();
        $despesas = $despesa->getByNome('Salario');
        $funcionarios = Funcionario::all();
        $comessas = Comessa::all();
        return view('financeiro.pagamentos.novopagamentosalario', 
                compact('pagamento','despesas','funcionarios','comessas','data_inicio','data_fim'));
    }
    public function PreencherDados($id,$de,$ate){
        if (Gate::denies('create-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $ddb = new Diariodebordo();
        $n_horas = 180;
        $pagamento = new Pagamento();
        $despesa = new Despesa();
        $despesas[] = $despesa->getByNome('Salário');
        $funcionarios = Funcionario::all();
        $funcionario = Funcionario::find($id);
        $funcionario_id[]=$id;
        $filtro = ['de'=>$de , 'ate'=>$ate, 'funcionario_id'=>$funcionario_id, 'tipo' => 'xlsx'];
        $filtro['titulo'] = 'Pagamento de salário';
        $dados = $ddb->getRelatorioSintetico($filtro);
        
        if (!empty($dados['infor'][0])){
            $n_horas = $dados['infor'][0][3];
            
        }

        $comessas = Comessa::all();
        $pagamento->valor_beneficio = $funcionario->getValorBeneficios($n_horas);
        $pagamento->valor_descontos = $funcionario->getValorDescontoBeneficios()+$funcionario->getValorDescontos($n_horas);
        $pagamento->valor = $funcionario->getValorSalarioLiquido($n_horas);

        return view('financeiro.pagamentos.preenchersalario', compact('pagamento','despesas','funcionarios','comessas'));
    }
    
   
    
    public function Apagar($idpagamento){
        if (Gate::denies('delete-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $pagamento = Pagamento::find($idpagamento);        
        $pagamento->delete();
        return redirect('/financeiro/pagamentos');
    }
    
  
    public function Salvar(Request $request){
        $user = auth()->user();

        if (Gate::denies('save-pagamento')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $pagamento = Pagamento::find($request->get('id'));
        if (!empty($pagamento)){ 
            $pagamento->fill($request->all()); 
            $pagamento->save();
            \Session::flash('mensagem_sucesso', "Pagamento ".$pagamento->nome." atualizado com sucesso ");
        }else {
              $pagamento = new Pagamento();
              $request['id']=$pagamento->id;              

              $pagamento->fill($request->all());
              $pagamento->save();

              
            \Session::flash('mensagem_sucesso', 'Pagamento cadastrado com sucesso');
        }  
        return redirect('/financeiro/pagamentos');
    }

   
}
