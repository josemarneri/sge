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
        
//        if (Gate::denies('create-relatoriohoras',$atividade)){
//    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
//    	}
        $funcionarios = Funcionario::all()->sortBy('nome');

        $comessas = Comessa::all();
        $de = '2021-02-01';
        $ate = '2021-02-28';
        $titulo = 'Relatório de Horas';
        //dd('here');
        return view('util.relatorios.relatoriodehoras', compact('funcionarios','comessas','de','ate','titulo'));
    }
    
    public function getFuncionarios($comessa_id){
        
        $comessa = Comessa::find($comessa_id);
        $funcionarios = $comessa->getFuncionarios();
        return view('util.relatorios.selectfuncionario', compact('funcionarios'));
    }
    
    public function GerarRelatorioHoras(Request $request){
        $ddb = new Diariodebordo();
        $de = $request['de'];
        $ate = $request['ate'];
        $periodo = ['de'=>$de,'ate'=>$ate];
        $titulo = $request['titulo'];
        $formato = $request['formato'];
        $comessa = $request['comessa'];
        $relatorio = new Relatorio();
        //dd($request);
        $funcionarios_id=$request['funcionario_id'];
        $arquivos;
        
        //Se nenhum funcionario tiver sido escolhido, usa o funcionario do user logado
        if (empty($funcionarios_id)){
            $funcionario = $ddb->getFuncionarioByUser();
            $funcionarios_id[] = $funcionario->id;
        }
        
        //Gera as planilhas e salva no servidor
            foreach ($funcionarios_id as $f_id){
                $dados = $ddb->getPorPeriodo($periodo,$f_id);  
                $dados['titulo'] = $titulo;
                //['filename' => $filename, 'mime' => $mime]
                $arquivos[$f_id] = $relatorio->getRelatorioHoras($dados, $formato);
            }    

        if (count($funcionarios_id) > 1){
            //        $files = array('readme.txt', 'test.html', 'image.gif');
            $fileName = $titulo.'.zip';
            $zipname = $titulo.'.zip';
//            $zipname = 'storage/'.$titulo.'.zip';
            $zip = new ZipArchive();
            $zip->open($zipname, ZipArchive::CREATE);
            foreach ($arquivos as $arq) {
                $file = $arq['filename'];
//                $file = 'storage/'.$arq['filename'];
                $zip->addFile($file);
            }
            $zip->close();


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
                //$headers = ['Content-Type: '.$mime];
                //$newName = $fileName;
                //dd($myFile, $newName, $headers);

                //return response()->download($myFile, $newName, $headers);
            }
        
        
        //$file= Storage::disk('public')->get($arquivos['filename']);
        
        


//        return (new Response($file, 200))->header('Content-Type', $retorno['mime']) ;
        
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
