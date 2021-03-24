<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Comessa;
use App\Models\Funcionario;
use App\Models\Financeiro;
use App\Models\Diariodebordo;
use App\Models\Relatorio;

class FinanceiroController extends Controller
{
    //
    public function index(){  
        $relatorio = new Relatorio();
        $data = date('Y-m-d');
        $periodo = $relatorio->getPeriodoMesAtual($data);
        
        if (Gate::denies('list_consultivarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();
        $de = $periodo['de'];
        $ate = $periodo['ate'];
        $titulo = 'Relatório de Horas';
        //dd('here');
        return view('util.relatorios.relatoriodehoras', 
                compact('funcionarios','comessas','de','ate','titulo'));
    }
    
    public function consultivarHoras(){        
        $relatorio = new Relatorio();
        $data = date('Y-m-d');
        $periodo = $relatorio->getPeriodoMesAtual($data);
        if (Gate::denies('list_consultivarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();
        $de = $periodo['de'];
        $ate = $periodo['ate'];
        //dd('here');
        return view('financeiro.consultivar.consultivarhoras', compact('funcionarios','comessas','de','ate'));
    }
    public function faturarHoras(){        
        $relatorio = new Relatorio();
        $data = date('Y-m-d');
        $periodo = $relatorio->getPeriodoMesAtual($data);
        if (Gate::denies('list_faturarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();
        $de = $periodo['de'];
        $ate = $periodo['ate'];
        //dd('here');
        return view('financeiro.faturar.faturarhoras', compact('funcionarios','comessas','de','ate'));
    }
    
    public function ConsultivarFiltrar(Request $request){         
        $financeiro = new Financeiro();
        $ddbordo = new Diariodebordo();
        $comessa_id = $request['comessa_id'];
        $de = $request['de'];
        $ate = $request['ate'];
        $selecionados;
        foreach ($request['funcionario_id'] as $f_id){
            $selecionados[$f_id] = 'selected';
        }

        if (Gate::denies('list-consultivarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        $diariosdebordo = $financeiro->Filtrar($request);
        
        $funcionarios = Funcionario::all()->sortBy('nome');
        $comessas = Comessa::all();

        return view('financeiro.consultivar.listconsultivohoras',
                compact('selecionados','comessas','diariosdebordo', 'comessa_id', 'de', 'ate','ddbordo', 'funcionarios'));
    }
    
    public function FaturarFiltrar(Request $request){         
        $financeiro = new Financeiro();
        $ddbordo = new Diariodebordo();
        $comessa_id = $request['comessa_id'];
        $de = $request['de'];
        $ate = $request['ate'];
        $selecionados;
        foreach ($request['funcionario_id'] as $f_id){
            $selecionados[$f_id] = 'selected';
        }

        if (Gate::denies('list-faturarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        $diariosdebordo = $financeiro->FiltrarConsultivados($request);
        
        $funcionarios = Funcionario::all()->sortBy('nome');
        $comessas = Comessa::all();

        return view('financeiro.faturar.listfaturamentohoras',
                compact('selecionados','comessas','diariosdebordo', 'comessa_id', 'de', 'ate','ddbordo', 'funcionarios'));
    }
    
    public function getFuncionarios($comessa_id){        
        $comessa = Comessa::find($comessa_id);
        $funcionarios = $comessa->getFuncionarios();
        return view('financeiro.consultivar.selectfuncionario', compact('funcionarios'));
    }
    
    public function ConsultivarSalvar(Request $request){        
        $n_horas_consultivadas = $request['n_horas_consultivadas'];        
        $consultivados = $request['consultivado'];
        $consultivar;
        if (Gate::denies('create-consultivarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        $financeiro = new Financeiro();
        $financeiro->limparConsultivados($n_horas_consultivadas);
        
        if (!empty($consultivados)){
            foreach ($consultivados as $cons){
                $diariodebordo = Diariodebordo::find($cons);
                $diariodebordo->consultivado = true;
                $diariodebordo->n_horas_consultivadas = $n_horas_consultivadas[$cons];
                $diariodebordo->save();
            }
        }
        
        return redirect('financeiro/consultivar');
    }
    public function FaturarSalvar(Request $request){
        $consultivados = $request['consultivado'];
        $nfs = $request['nf'];
        $faturados = $request['faturado'];
        if (Gate::denies('create-faturarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        $financeiro = new Financeiro();
        $financeiro->limparFaturados($consultivados);
        if (!empty($faturados)){
            foreach ($faturados as $id=>$fat){
                $diariodebordo = Diariodebordo::find($fat);
                $diariodebordo->faturado = true;
                $diariodebordo->nf = $nfs[$id];
                $diariodebordo->save();
            }
        }
        
        return redirect('financeiro/faturar');
    }
    
    
    
    
}

