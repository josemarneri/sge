<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use PHPExcel; 
//use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;//classe responsável pela manipulação da planilha
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //classe que salvará a planilha em .xlsx
use PhpOffice\PhpSpreadsheet\Writer\Ods\Styles;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\Desenho;


use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\Projeto;


class Relatorio extends Model
{
    use HasFactory;
    
    public function existFile($filename){
        if (!file_exists($filename)) {
                exit("Arquivo não encontrado");
                return null;
        }else{
           // $objPHPExcel = PHPExcel_IOFactory::load($filename);
            $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
            $ci = $objPHPExcel->getActiveSheet()->calculateWorksheetDataDimension();
            $campos = $objPHPExcel->getActiveSheet()->rangeToArray($ci);
            return $campos;
        }
        
        //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('phpcomexcel.xlsx');
    }
    
    
    
    public function existPlanilha(){
        $filename = 'storage/Filtro de desenhos - '. auth()->user()->name . '.xlsx';
        if (file_exists($filename)) {
            return true;
        }else{           
            return false;
        }
    }
    
    public function ReadExcel($filename){
        //dd($filename);
        $campos = $this->existFile($filename);
        //dd('aqui');
        $nlines = count($campos);
        $ncols = count($campos[0]);
        //dd(aqui1);
        for ($i=0; $i<$nlines; $i++){
            for ($j=0; $j<$nlines; $j++){
                
                
            }
            
        }
        
     return $campos;   
    }
    
    public function gerarListaDesenhosExcel($desenhos){
        $desenho = new Desenho();
        $filename = 'storage/Filtro de desenhos - '. auth()->user()->name . '.xlsx';
        $projeto = new Projeto();
        $styleArrayCabecalho = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                            'rotation' => 90,
                            'startColor' => [
                                'argb' => 'FFA0A0A0',
                            ],
                            'endColor' => [
                                'argb' => 'FFFFFFFF',
                            ],
                        ],
                    ];
        $styleArrayCorpo = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                        ],
                        
                    ];
        
        $spreadsheet = new Spreadsheet(); //instanciando uma nova planilha
        //$spreadsheet = $reader->load($arquivo);
        $spreadsheet->createSheet();
        $sheet_count = $spreadsheet->getSheetCount();
//        dd($sheet_count);
//        for ($i=0 ; $i < $sheet_count ; $i++) {
//            $sheet = $spreadsheet->getSheet($i);
//
//            // processa os dados da planilh
//        }
        $sheet = $spreadsheet->getSheet(0)->setTitle("Desenhos"); //retornando a aba 0
        $sheet2 = $spreadsheet->getSheet(1)->setTitle("Filiação"); //retornando a aba 1
        $nlines = (!empty($desenhos))? count($desenhos):0 ;
        
        //Dimensiona as colunas em autosize
        for($k=65; $k<90; $k++){
            $sheet->getColumnDimension(chr($k))->setAutoSize(true);
            $sheet2->getColumnDimension(chr($k))->setAutoSize(true);
        }
        
        // Define o estilo da planilha e do Cabeçalho em seguida
        $sheet->getStyle("A1:I".($nlines+1))->applyFromArray($styleArrayCorpo);
        $sheet->getStyle("A1:I1")->applyFromArray($styleArrayCabecalho);
        $sheet2->getStyle("A1:B1")->applyFromArray($styleArrayCabecalho);
        
        // Cria cabeçalho da planilha 0
        $sheet->setCellValue('A1','NÚMERO'); 
        //$sheet->setCellValue('B1','PAI');                
        $sheet->setCellValue('B1','ALIAS');                
        $sheet->setCellValue('C1','DESCRIÇÃO');                
        $sheet->setCellValue('D1','MATERIAL');                
        $sheet->setCellValue('E1','PESO (kg)');                
        $sheet->setCellValue('F1','TRATAMENTO');                
        $sheet->setCellValue('G1','PROJETO');                
        $sheet->setCellValue('H1','OBSERVAÇÕES');
        
        // Cria cabeçalho da planilha 1
        $sheet2->setCellValue('A1','PAI'); 
        $sheet2->setCellValue('B1','FILHO');
        
        $pos = strrpos($sheet2->calculateWorksheetDataDimension(), ':');
        //$n= substr($sheet2->calculateWorksheetDataDimension(),1, $pos-1)+1; 
        $lista;
        //Copia do array para a planilha
        for ($i=0; $i<$nlines; $i++){
            $desenho =$desenho->getById($desenhos[$i]->id);
            $sheet->setCellValue('A'.($i+2),$desenhos[$i]->numero);                
            //$sheet->setCellValue('B'.($i+2),$desenhos[$i]->pai);                
            $sheet->setCellValue('B'.($i+2),$desenhos[$i]->alias);                
            $sheet->setCellValue('C'.($i+2),$desenhos[$i]->descricao);                
            $sheet->setCellValue('D'.($i+2),$desenhos[$i]->material);                
            $sheet->setCellValue('E'.($i+2),$desenhos[$i]->peso);                
            $sheet->setCellValue('F'.($i+2),$desenhos[$i]->tratamento);                
            $sheet->setCellValue('G'.($i+2),$projeto->getCodigoById($desenhos[$i]->projeto_id));                
            $sheet->setCellValue('H'.($i+2),$desenhos[$i]->observacoes);
            
//            $pais = $desenho->getPais();
//            $filhos = $desenho->getFilhos();
            $conjuntos = $desenho->getConjuntos();
            foreach($conjuntos as $c){
                $lista[$c->id] = ['pai_id'=>$c->pai_id, 'filho_id'=>$c->filho_id];
            }
            
            
//            foreach($pais as $p){ 
//                
//                $sheet2->setCellValue('A'.($n),$desenho->getById($p->pai_id)->numero);
//                $sheet2->setCellValue('B'.($n),$desenho->numero);
//                $n++;
//            }
            //dd($n);
//            foreach($filhos as $f){
//                $sheet2->setCellValue('A'.($n),$desenho->numero);
//                $sheet2->setCellValue('B'.($n),$desenho->getById($f->filho_id)->numero);
//                $n++;
//            }
        }
        //dd($lista);
        $n = 2; 
        if (!empty($lista)){
            foreach($lista as $l){ 
                $sheet2->setCellValue('A'.($n),$desenho->getById($l['pai_id'])->numero);
                $sheet2->setCellValue('B'.($n),$desenho->getById($l['filho_id'])->numero);
                $n++;
            }
        }
        
        $spreadsheet->setActiveSheetIndex(0);
        
        //Escrevendo filiação dos desenhos      
        
        
        //Salva planilha       
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filename);
        //dd('gerou');
        //dd(storage_path());


        
        //$mime = $file->getClientMimeType();
        //dd(new Response($file, 200))->header('Content-Type', $arquivo->mime);
        return $filename;
        
        
    }
    
    public function gerarPDF($htmlPage){
//        $pdf = app()->make('dompdf.wrapper'); // $pdf is now a PDF instance
//
//        $pdf->getDomPDF()->setBasePath(public_path().'/img/');
//
//        //$pdf = PDF::loadHTML($content); // don't create a NEW instance, use the existing $pdf instance
//        $pdf->loadHTML($content);

        
        // instanciando o dompdf
        //$css = '/public/css';      
        
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->set_base_path(public_path().'/css/');
        $dompdf->setBaseHost(resource_path().'/plm/');
        $
        
              
        //dd($dompdf);

        //lendo o arquivo HTML correspondente
        $html = file_get_contents($htmlPage);

        //inserindo o HTML que queremos converter
        $dompdf->loadHtml($html);
        //$codigo_html = "<h1>Olá mundo!</h1><p>Geramos o arquivo com o dom pdf, ihul!</p>";
        //$dompdf->loadHtml($codigo_html);

        // Definindo o papel e a orientação
        $dompdf->setPaper('A4', 'landscape');

        // Renderizando o HTML como PDF
        $dompdf->render();

        // Enviando o PDF para o browser
        $dompdf->stream();
        
        
    }
    
    
}
