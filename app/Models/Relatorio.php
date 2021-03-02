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
use App\Models\Others\Math;
use App\Models\Comessa;
use App\Models\Atividade;


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
    
    
    public function getPeriodo($periodo){
        $ano = substr($periodo, 0,4);
        $mes = substr($periodo, 5,2);
        //$lastDay = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $lastDay = 31;
        $fds;
        for ($i=1; $i<=$lastDay; $i++){
            $fds[$i] = date("D", strtotime($ano.'-'.$mes.'-'.$i));
        }
//        dd($ano,$mes,$fds);
        $strDe = substr($periodo, 0,10);
        $strAte = substr($periodo, 13,10);
        $periodo = ['de'=> $strDe, 'ate'=>$strAte, 'fds'=>$fds];
        return $periodo;
    }

    
    public function gerarListaDesenhosExcel($desenhos){
        $desenho = new Desenho();
        $filename = 'storage/Filtro de desenhos - '. auth()->user()->name . '.xlsx';
        //$filename = 'storage/Filtro de desenhos - '. auth()->user()->name . '.pdf';
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
        //dd($desenhos);
        //Copia do array para a planilha
        if (!empty($desenhos)){
            for ($i=0; $i<$nlines; $i++){
                $desenho =$desenho->getById($desenhos[$i]->id);
                //dd($desenhos);
                //dd($nlines);
                $sheet->setCellValue('A'.($i+2),$desenhos[$i]->numero);                
                //$sheet->setCellValue('B'.($i+2),$desenhos[$i]->pai);                
                $sheet->setCellValue('B'.($i+2),$desenhos[$i]->alias);                
                $sheet->setCellValue('C'.($i+2),$desenhos[$i]->descricao);                
                $sheet->setCellValue('D'.($i+2),$desenhos[$i]->material);                
                $sheet->setCellValue('E'.($i+2),$desenhos[$i]->peso);                
                $sheet->setCellValue('F'.($i+2),$desenhos[$i]->tratamento);                
                $sheet->setCellValue('G'.($i+2),$projeto->getCodigoById($desenhos[$i]->projeto_id));                
                $sheet->setCellValue('H'.($i+2),$desenhos[$i]->observacoes);

                $conjuntos = $desenho->getConjuntos();
                foreach($conjuntos as $c){
                    $lista[$c->id] = ['pai_id'=>$c->pai_id, 'filho_id'=>$c->filho_id];
                }

            }
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
        //$writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
        //$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
        $writer->save($filename);

        return $filename;
        
        
    }
    public function getRelatorioExcel($dados, $formato){
        $filename = 'storage/Relatorio - '. auth()->user()->name . '.'. $formato;
        //$filename = 'storage/Filtro de desenhos - '. auth()->user()->name . '.pdf';
        $projeto = new Projeto();
        $styleArrayTitulo = [
                        'font' => [
                            'bold' => true,
                            'color' => array('rgb' => 'FFFFFFFF'),
                            'size'  => 20,
                            'name'  => 'Arial',
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
        $styleArrayCabecalho = [
                        'font' => [
                            'bold' => true,
                            'color' => array('rgb' => 'FFFFFFFF'),
                            'size'  => 15,
                            'name'  => 'Arial',
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
        $sheet = $spreadsheet->getSheet(0)->setTitle($dados['nomeAba']); //retornando a aba 0
//        $sheet2 = $spreadsheet->getSheet(1)->setTitle("Filiação"); //retornando a aba 1
        if (!empty($dados)){
            $nlines =count ($dados['infor']) ;
            //dd($nlines);
            $ncols = count($dados['cabecalho']);
            //Dimensiona as colunas em autosize
            for($k=65; $k<90; $k++){
                $sheet->getColumnDimension(chr($k))->setAutoSize(true);
            }
            
             $lastCol = chr ($ncols+65);
            // Define o estilo da planilha e do Cabeçalho em seguida
             //dd($lastCol);
            $sheet->getStyle("A1:".$lastCol.($nlines+3))->applyFromArray($styleArrayCorpo);
       //dimensionar depois
       
            $sheet->getStyle("A1:".$lastCol.'1')->applyFromArray($styleArrayTitulo);
            $sheet->getStyle("A2:".$lastCol.'2')->applyFromArray($styleArrayCabecalho);
            $sheet->mergeCells('A1:'.$lastCol.'1');
//            $sheet->getRowDimension(1)->setRowHeight(35);

            // Cria cabeçalho da planilha 0
            $sheet->setCellValue('A1',$dados['titulo']);
            foreach($dados['cabecalho'] as $c=>$texto){
                $col = chr($c+65);
                $sheet->setCellValue($col.'2',$texto);
            }
            //dd($dados['infor']);
            
            for ($i=0; $i<$nlines; $i++){
                $linha = $dados['infor'][$i];
                
                if (!empty($linha)){
                    $k=65;
                    foreach($linha as $l){
                        $sheet->setCellValue(chr($k).($i+3),$l);
                        $k++;
                    }
                }
            }
        }
        
        $spreadsheet->setActiveSheetIndex(0);
        
        //Escolhendo formato para salvamento        
        switch ($formato) {
            case 'pdf':
                //$writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                $writer->save($filename);
                break;
            case 'xlsx':
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save($filename);
                break;
        }

        return $filename;
        
    }
    public function getRelatorioHoras($dados, $formato){
        $dir = 'storage';
        $filename = 'Relatorio - '. $dados['cabecalho']['nome'] . '.'. $formato;
        $saveName = $filename;
//        $saveName = $dir.'/'.$filename;
        $mime;
        //$filename = 'storage/Filtro de desenhos - '. auth()->user()->name . '.pdf';
        $projeto = new Projeto();
        $math = new Math();
        
        //instanciando uma nova planilha
        $spreadsheet = new Spreadsheet(); 
        //$spreadsheet->createSheet();
        
        //Estilos da planilha
        if(true){
            $styleArrayTitulo = [
                    'font' => [
                        'bold' => true,
                        'size'  => 20,
                        'name'  => 'Arial',
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        ],
                    ],
                ];
        $styleArrayCabecalho = [
                    'font' => [
                        'bold' => true,
                        //'color' => array('rgb' => 'FFFFFFFF'),
                        'size'  => 12,
                        'name'  => 'Arial',
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        ],
                    ],
                ];
        $styleArrayFDS = [
                    'font' => [
                        'bold' => true,
                        //'color' => array('rgb' => 'FFFFFFFF'),
                        'size'  => 12,
                        'name'  => 'Arial',
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
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_LIGHTUP,
                            'rotation' => 90,  
                            'color' => array('rgb' =>'D3D3D3')
                        ],
                ];
        $styleArrayCorpo = [
                    'font' => [
                        'bold' => false,
                        'size'  => 12,
                        'name'  => 'Arial',
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
        }
        
//        $sheet_count = $spreadsheet->getSheetCount();
        $numSheets = count($dados['infor']);
        if (!empty($dados)){
            $aba=0;
            foreach($dados['infor'] as $periodo=>$infor){
                $invalidCharacters = $spreadsheet->getSheet(0)->getInvalidCharacters();
                $periodo = str_replace($invalidCharacters, '', $periodo);
                $sh = $spreadsheet->getSheet($aba)->setTitle($periodo); //retornando a aba 1
                $periodoFormatado =   $this->getPeriodo($periodo);
                
//                dd($periodo,$infor);
                //Preenchimento da aba
                
                //Mesclar as celulas 
                $sh->mergeCells('A1:B1');    // Campo logo
                $sh->mergeCells('C1:AH1');   // Titulo        
                $sh->mergeCells('B2:I2');    // Nome do Funcionario
                $sh->mergeCells('J2:M2');    // Texto Cliente
                $sh->mergeCells('N2:Z2');   // Cliente
                $sh->mergeCells('AA2:AH2');  // Texto Periodo
        //        $sh->mergeCells('A3:B3');    // Texto Empresa
                $sh->mergeCells('B3:I3');    // Empresa
                $sh->mergeCells('J3:M3');    // Texto Responsável
                $sh->mergeCells('N3:Z3');   // Responsável
                $sh->mergeCells('AB3:AD3');  // Data inicial
                $sh->mergeCells('AF3:AH3');  // Data final
                $sh->mergeCells('A4:AH4');   // Linha em branco
        //        $sh->mergeCells('A5:C5');   // Texto atividades
        //        
                //Configuração do cabeçalho

        //        $sh2 = $spreadsheet->getSheet(1)->setTitle("Filiação"); //retornando a aba 1

                $nlines =count ($dados['infor']) ;
                //dd($nlines);
                $ncols = count($dados['cabecalho']);

                //Dimensiona as colunas com tamanho definido
                $sh->getColumnDimension('A')->setWidth(17);
                $sh->getColumnDimension('B')->setWidth(50);


                //Dimensiona linhas com tamanho definidos
                $sh->getRowDimension(4)->setRowHeight(5);
                $sh->getRowDimension(1)->setRowHeight(50);

                 $lastCol = 'AH';

                // Define os estilos da planilha                  
                $sh->getStyle("A1:AH1")->applyFromArray($styleArrayTitulo);
                $sh->getStyle("A2:AH5")->applyFromArray($styleArrayCabecalho);
                $sh->getStyle("AA2:AH2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sh->getStyle("A1:AH1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sh->getStyle("C1:AH1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


    //            $sh->getRowDimension(1)->setRowHeight(35);

                // Cria cabeçalho da planilha 0
                $sh->setCellValue('C1',$dados['titulo']);

                $sh->setCellValue('A2','NOME:');
                $sh->setCellValue('B2',$dados['cabecalho']['nome']);
                $sh->setCellValue('J2','CLIENTE:');
                $sh->setCellValue('N2',$dados['cabecalho']['cliente']);
                $sh->setCellValue('AA2','PERÍODO:');
                $sh->setCellValue('A3','EMPRESA:');
                $sh->setCellValue('B3',$dados['cabecalho']['empresa']);
                $sh->setCellValue('J3','RESPONSÁVEL:');
                $sh->setCellValue('N3',$dados['cabecalho']['responsavel']);
                $sh->setCellValue('AA3','DE:');
                $sh->setCellValue('AB3',$periodoFormatado['de']);
                $sh->setCellValue('AE3','ATÉ:');
                $sh->setCellValue('AF3',$periodoFormatado['ate']);            
                $sh->setCellValue('A5','CÓDIGO');
                $sh->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sh->setCellValue('B5','ATIVIDADES');
                $sh->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //Escreve de 1 a 31, no cabeçalho da planilha 66 é 'B' em ascII e marca os finais de semana        
                for ($m=1; $m<=24; $m++){
                    if (($periodoFormatado['fds'][$m] == 'Sat') || ($periodoFormatado['fds'][$m] == 'Sun')){
                        $sh->getStyle(chr($m+66).'5')->applyFromArray($styleArrayFDS);
                    }
                    $sh->setCellValue(chr($m+66).'5',$m);
                    $sh->getColumnDimension(chr($m+66))->setWidth(7);
                    $sh->getStyle(chr($m+66).'5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }            
                for ($m=1; $m<=7; $m++){
                    if (($periodoFormatado['fds'][$m+24] == 'Sat') || ($periodoFormatado['fds'][$m+24] == 'Sun')){
                        $sh->getStyle('A'.chr($m+64).'5')->applyFromArray($styleArrayFDS);
                    }
                    $sh->setCellValue('A'.chr($m+64).'5',$m+24);
                    $sh->getColumnDimension('A'.chr($m+64))->setWidth(7);
                    $sh->getStyle('A'.chr($m+64).'5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }            
                $sh->setCellValue('AH5','TOTAL');
                $sh->getStyle('AH5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sh->getColumnDimension('AH')->setAutoSize(true);

    //            $sh->getDefaultRowDimension()->setRowHeight(15);

                $lastRow = 30;            
                
                $comessas = [];      //usado para evitar duplicação de linhas na planilha
                $ln = 6;            //Linha atual
                $lnComessa = $ln;   //Linha da comessa
                $comessa = new Comessa();
                $atividade = new Atividade();
                foreach ($infor as $inf){
                    $comessa = $comessa->find($inf->comessa_id);
                    $codigo = $comessa->codigo;
                    if (!empty($inf->atividade_id)){
                        $atividade = $atividade->find($inf->atividade_id);
                        $codigo = $atividade->codigo;
                    }

                    if (empty($comessas[$codigo])){
                        $comessas[$codigo] = $ln;
                        $lnComessa = $ln;
                        $ln++;
                        $lastRow = ($ln > $lastRow)? $ln + 1 : $lastRow;
                    }
                    $lnComessa = $comessas[$codigo];
                    //Colunas vão da C(67) a AG('A'.chr(G)
                    $dia = $strDe = substr($inf->data, 8,2);
                    $col = (($dia + 66)<=90)? chr($dia + 66): 'A'.chr($dia + 66 - 26);
                    
                    //Colocar a descrição da atividade
                    $sh->getStyle('B'.$lnComessa)->getAlignment()->setWrapText(true);                    
                    $sh->setCellValue('B'.$lnComessa,$inf->descricao);
                    
                    //Colocar a comessa
                    $sh->getStyle('B'.$lnComessa)->getAlignment()->setWrapText(true);                    
                    $sh->setCellValue('A'.$lnComessa,$codigo);
                    
                    //Numero de horas do dia
                    $jaLancado = $sh->getCell($col.$lnComessa)->getValue();
                    $lancar = $math->horasToDec($inf->n_horas) + $jaLancado;
                    $sh->setCellValue($col.$lnComessa,$lancar);
//                        dd($inf,$dia,$col.$lnComessa);                         
                } 
                //dd($comessas);
                
                // 2 For para colocar as os somatórios da ultima linha
                for ($m=1; $m<=24; $m++){
                    $sh->setCellValue(chr($m+66).($lastRow+1),'=sum('.chr($m+66).'6:'. chr($m+66) . $lastRow .')');
                    $sh->getStyle(chr($m+66).($lastRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }            
                for ($m=1; $m<=8; $m++){
                    $sh->setCellValue('A'.chr($m+64).($lastRow+1),'=sum(A'.chr($m+64).'6:A'. chr($m+64) . $lastRow .')');
                    $sh->getStyle('A'.chr($m+64).($lastRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                } 
                // For para colocar as os somatórios da coluna AH
                for($j=6; $j<=$lastRow; $j++){               
                    $sh->setCellValue('AH'.$j,'=sum(C'. $j.':AH'.$j.')');                
                }  
                
                    


                //Define o estilo do corpo
                $sh->getStyle("A5:AH5")->applyFromArray($styleArrayCorpo); 
                $sh->getStyle("A6:AH".$lastRow)->applyFromArray($styleArrayCorpo);
                $sh->getStyle('A'.($lastRow + 1).':AH'.($lastRow + 1))->applyFromArray($styleArrayCorpo);

                //Configuração das sheets
                $sh->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sh->getPageSetup()->setFitToWidth(1);
                $sh->getPageSetup()->setFitToHeight(1);
                $sh->getPageMargins()->setTop(.25);
                $sh->getPageMargins()->setRight(0.15);
                $sh->getPageMargins()->setLeft(0.15);
                $sh->getPageMargins()->setBottom(.25);
                $sh->setShowGridlines(false);
        //        $sh->getPageSetup()->setPrintArea('A1:E5');
                
                $aba++;
                if ($aba < $numSheets){
                    $spreadsheet->createSheet();
                }
                
            }
                
                
                
                //Fim do preenchimento da aba
    
        }   
                
        
        
        
        //Proteção
//        $protection = $sheet->getProtection();
//        $protection->setPassword('123');
//        $protection->setSheet(true);
//        $protection->setSort(true);
//        $protection->setInsertRows(true);
//        $protection->setFormatCells(true);
        
        $spreadsheet->setActiveSheetIndex(0);
        
        //Escolhendo formato para salvamento        
        switch ($formato) {
            case 'pdf':
                $mime = "application/pdf";
                //$writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                $writer->writeAllSheets();
//                $writer->setSheetIndex(0);
                $writer->save($saveName);
                break;
            case 'xlsx':
                $mime = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save($saveName);
                break;
        }
        $retorno = ['filename' => $filename, 'mime' => $mime];
        return $retorno;
        
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
