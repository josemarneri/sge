<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Models\Comessa;
use App\Models\Funcionario;
use App\Models\Financeiro;
use App\Models\Diariodebordo;

class FinanceiroController extends Controller
{
    //
    public function index(){        
        
//        if (Gate::denies('create-relatoriohoras',$atividade)){
//            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
//        }
        
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();
        $de = '2021-02-01';
        $ate = '2021-02-28';
        $titulo = 'Relatório de Horas';
        //dd('here');
        return view('util.relatorios.relatoriodehoras', 
                compact('funcionarios','comessas','de','ate','titulo'));
    }
    
    public function consultivarHoras(){        
        
        if (Gate::denies('list_consultivarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();
        $de = '2021-02-01';
        $ate = '2021-02-28';
        //dd('here');
        return view('financeiro.consultivar.consultivarhoras', compact('funcionarios','comessas','de','ate'));
    }
    
    public function Filtrar(Request $request){         
        $financeiro = new Financeiro();
        $ddbordo = new Diariodebordo();
        
        $comessa_id = $request['comessa_id'];
        $de = $request['de'];
        $ate = $request['ate'];
        $selecionados;
        foreach ($request['funcionario_id'] as $f_id){
            $selecionados[$f_id] = 'selected';
        }
        
        $diariosdebordo = $financeiro->Filtrar($request);
        foreach ($diariosdebordo as $ddbs){
            if (!empty($ddbs)){
                foreach ($ddbs as $ddb){
                    //dd($ddb);
                }
                
            }
            
        }
        if (Gate::denies('list-consultivarhoras')){
            abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
        }
        
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();

        //dd('here');
        return view('financeiro.consultivar.listconsultivohoras',
                compact('selecionados','comessas','diariosdebordo', 'comessa_id', 'de', 'ate','ddbordo', 'funcionarios'));
    }
    
    public function getFuncionarios($comessa_id){        
        $comessa = Comessa::find($comessa_id);
        $funcionarios = $comessa->getFuncionarios();
        return view('financeiro.consultivar.selectfuncionario', compact('funcionarios'));
    }
    
    
    
    
}

