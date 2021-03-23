<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Dompdf\Dompdf;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Relatorio;
use App\Models\Desenho;
use App\Models\Diariodebordo;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Gate;
use App\Models\Comessa;
use App\Models\Funcionario;
use ZipArchive;

class RelatorioController extends Controller{
    //

    public function index(){

    }
    
    public function RelatorioHoras(){
        $relatorio = new Relatorio();
        $data = date('Y-m-d');
        $periodo = $relatorio->getPeriodoMesAtual($data);
        $comessa = new Comessa();
        if (Gate::denies('list-relatoriohoras')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (!Gate::denies('create-relatoriohoras')){
            $comessas = Comessa::all();
    	}else{

            $comessas = $comessa->getByUser();
        }

        $funcionarios = Funcionario::all()->sortBy('nome');        
        $de = $periodo['de'];
        $ate = $periodo['ate'];
        $titulo = 'Relatório de Horas';
//        dd($periodo);
        return view('util.relatorios.relatoriodehoras', compact('funcionarios','comessas','de','ate','titulo'));
    }
    public function RelatorioHorasGeral(){
        if (Gate::denies('list-relatoriohoras')){
                abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
            }
        $relatorio = new Relatorio();
        $data = date('Y-m-d');
        $periodo = $relatorio->getPeriodoMesAtual($data);
        if (Gate::denies('create-relatoriohoras')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();
        $de = $periodo['de'];
        $ate = $periodo['ate'];
        $titulo = 'Relatório de Horas';
//        dd($periodo);
        return view('util.relatorios.relatoriodehoras', compact('funcionarios','comessas','de','ate','titulo'));
    }
    
    public function getFuncionarios($comessa_id){
        
        $comessa = Comessa::find($comessa_id);
        $funcionarios = $comessa->getFuncionarios();
        return view('util.relatorios.selectfuncionario', compact('funcionarios'));
    }
    
    //Gera relatório de horas detalhado, ou seja, gera as planilhas de horas
    public function GerarRelatorioHoras(Request $request){
        
        $ddb = new Diariodebordo();
        $de = $request['de'];
        $ate = $request['ate'];
        $periodo = ['de'=>$de,'ate'=>$ate];
        $titulo = $request['titulo'];
        $formato = $request['formato'];
        $comessa = empty($request['comessa_id'])? null : Comessa::find($request['comessa_id']);
        $relatorio = new Relatorio();
        $tipo = empty($request['tipo']) ? 'detalhado' : $request['tipo'];
        $funcionarios_id=$request['funcionario_id'];
        $arquivos;
        
        //Se nenhum funcionario tiver sido escolhido, usa o funcionario do user logado
        if (empty($funcionarios_id)){
            $funcionario = $ddb->getFuncionarioByUser();
            $funcionarios_id[] = $funcionario->id;
            $request['funcionario_id'] = [$funcionario->id];
        }
        
        //Gera as planilhas e salva no servidor
         switch ($tipo) {
            case 'detalhado':
                foreach ($funcionarios_id as $f_id){
                    $dados = $ddb->getPorPeriodo($periodo,$f_id, $comessa);  
                    $dados['titulo'] = $titulo;
                    $arquivos[$f_id] = $relatorio->getRelatorioHoras($dados, $formato);
                }
            break;
            case 'analitico':  
                if (Gate::denies('create-relatoriohoras')){
                    abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
                }
                $dados = $ddb->getRelatorioAnalitico($request);  
                $arquivos[] = $relatorio->getRelatorioPadrao($dados, $formato);
            break; 
            case 'sintetico':  
                if (Gate::denies('create-relatoriohoras')){
                    abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
                }
                $dados = $ddb->getRelatorioSintetico($request);  
                $arquivos[] = $relatorio->getRelatorioPadrao($dados, $formato);
            break; 
        }
            
        
        //Caso mais de um funcionário seja selecionado, será criado um arquivo zipado com
        // todos os aruivos criados
        if (count($funcionarios_id) > 1 && $tipo=="detalhado"){
            //        $files = array('readme.txt', 'test.html', 'image.gif');
            $fileName = $titulo.'.zip';
            $zipname = $titulo.'.zip';
//            $zipname = 'storage/'.$titulo.'.zip';
            $zip = new ZipArchive();
            $zip->open($zipname, ZipArchive::CREATE);
            
            //Adiciona os arquivos ao zip
            foreach ($arquivos as $arq) {
                $file = $arq['filename'];
//                $file = 'storage/'.$arq['filename'];
                $zip->addFile($file);
            }
            $zip->close();
            //Deleta os arquivos após inserir ao zip
            foreach ($arquivos as $arq) {
                unlink($arq['filename']);
            }
            


            // Primeiro nos certificamos de que o arquivo zip foi criado.
            if(file_exists($zipname)){
                // Forçamos o donwload do arquivo.
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="'.$fileName.'"');
                readfile($zipname);
                //removemos o arquivo zip após download
                unlink($zipname);
            } 
        }else{
                $fileName;
                $mime;
                if (!empty($arquivos)){                    
                     foreach ($arquivos as $arq) {
                        $fileName = $arq['filename'];
                        $mime = $arq['mime'];
                    }
                    //$file= Storage::disk('public')->get($arquivos['filename']);
                    $myFile = public_path($fileName);
    //                $myFile = public_path('storage/'.$fileName);
                    if(file_exists($myFile)){
                        // Forçamos o donwload do arquivo.
                        header('Content-Type: '.$mime);
                        header('Content-Disposition: attachment; filename="'.$fileName.'"');
                        readfile($myFile);
                        //removemos o arquivo zip após download
                        unlink($myFile);
                    } 
                }
               
            }

        
    }
    public function GerarRelatorio(){
        $formato = 'xlsx';
//        $formato = 'pdf';
        $relatorio = new Relatorio();
        //$user = new User();
        $desenho = new Desenho();
        $ddb = new Diariodebordo();
        
        $periodo = ['de'=>'2020-12-03','ate'=>'2021-02-29'];
        
        $lista = $ddb->getPorPeriodo($periodo);
        //dd($lista);
        
        $dados['nomeAba'] = 'Relatório de Horas';
        $dados['titulo'] = 'Relatório de Horas';
        $dados['cabecalho'] = ['nome' => 'Josemar Neri',
                                'empresa' => 'NSD',
                                'cliente' => 'FCA',
                                'responsavel' => 'Fulano',
                                'de' => $periodo['de'],
                                'ate' => $periodo['ate']
                ];
//        $infor = DB::table('desenhos')
//                ->select($desenho->getAtributos())->get()->all();
        $dados['infor'] = $lista;
        //dd($dados['infor']);
        $retorno = $relatorio->getRelatorioHoras($dados, $formato);
        //$filename = 'Relatorio - '. auth()->user()->name . '.'. $formato;
        
        $file= Storage::disk('public')->get($retorno['filename']);
        
        $myFile = public_path('storage/'.$retorno['filename']);
        $headers = ['Content-Type: '.$retorno['mime']];
        $newName = $retorno['filename'];


        return response()->download($myFile, $newName, $headers);


//        return (new Response($file, 200))->header('Content-Type', $retorno['mime']) ;
        
    }

}
