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

class RelatorioController extends Controller{
    //

    public function index(){
        // instanciando o dompdf

        $dompdf = new Dompdf();

        //lendo o arquivo HTML correspondente

        $html = file_get_contents('exemplo.html');

        //inserindo o HTML que queremos converter

        $dompdf->loadHtml($html);

        // Definindo o papel e a orientação

        $dompdf->setPaper('A4', 'landscape');

        // Renderizando o HTML como PDF

        $dompdf->render();

        // Enviando o PDF para o browser

        $dompdf->stream();
    }
    
    public function GerarRelatorio(){
        $formato = 'xlsx';
        $formato = 'pdf';
        $relatorio = new Relatorio();
        //$user = new User();
        $desenho = new Desenho();
        $ddb = new Diariodebordo();
        
        $periodo = ['de'=>'2020-12-01','ate'=>'2021-02-21'];
        
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
        $relatorio->getRelatorioHoras($dados, $formato);
        
    }

}
