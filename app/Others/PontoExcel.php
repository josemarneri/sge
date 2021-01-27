<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Others;

//use PHPExcel; 
//use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;//classe responsável pela manipulação da planilha
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //classe que salvará a planilha em .xlsx


use App\Models\Rdp;
use App\Models\Funcionario;
use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Description of PontoExcel
 *
 * @author neri
 */
class PontoExcel {
    //put your code here
    
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


    public function ReadExcel($filename){
        
        $campos = $this->existFile($filename);
        $nlines = count($campos);
        $nome = null;
        $reg = null;
        for ($i=0; $i<$nlines; $i++){
            switch ($campos[$i][0]){                
                case "Crachá:": 
                    $reg = (int) ($campos[$i][1]); 
                    break;
                case "Nome:": 
                    $nome = $campos[$i][1]; 
                    break;
                case "Data": 
                    $k=++$i; $data=$campos[$k][0];
                    while ($data != "D. Trab.: "){
                        if ($data != null){
                            $df = \DateTime::createFromFormat('d/m/Y', $data);                            
                            $df = $df->format('Y-m-d');
                            //dd($data,$df);
                            $entr1=$campos[$k][3];
                            $sai1=$campos[$k][4];
                            $entr2=$campos[$k][5];
                            $sai2=$campos[$k][6];
                            $htrab= $campos[$k][13];
                            $habon= $campos[$k][14];
                            $hdeb= $campos[$k][15];
                            $rdp = Rdp::where('funcionario_id','=',$reg)
                                    ->where('data','=', $df)->first();
                            
                            $soma=$this->isRegistroOK($htrab, $hdeb);
                            
                            if (count($rdp)<1){
                                if($soma == 0){
                                    $rdp = new Rdp();
                                    $r = ['funcionario_id'=> $reg,'data' =>  $df, 'entr1'=>$entr1,
                                        'entr2'=>$entr2, 'sai1'=>$sai1,'sai2'=>$sai2,'htrab' =>$htrab,
                                        'habon' => $habon,'hdeb' => $hdeb];
                                    $rdp->create($r);
                                    DB::insert('insert into lancamentos_pendentes '
                                        . '(funcionario_id, data, horas_pendentes)'
                                        . 'values(?,?,?)', 
                                        array($reg,$df,8.0)); 
                                }else if($soma<0){
                                    var_dump($soma,$nome,$data);
                                    //ocorrencia de ponto
                                }else{
                                    //horas extras
                                }
                                
                            }
                                
//                            echo '<br>' . $k . ' => '.$data .' '.$entr1.' '.$sai1.' '.$entr2.' '.$sai2.' '.
//                                    $htrab.' '.$habon.' '.$hdeb;
                        }
                        $k++; 
                        $data=$campos[$k][0];
                    }
                    break;
                case "D. Trab.: ":
                    $dtrab = $campos[$i][1];
                    $dfalta = $campos[$i][3];
                    $dsr = $campos[$i][5];
                    $ddsr = $campos[$i][7];
                    $folgas = $campos[$i][9];
                    $thtrab = $campos[$i][11];
                    $thabon = $campos[$i][12];  
                    $thdeb = $campos[$i][13];
                    echo '<br>' . $i . ' => '.$dtrab .' '.$dfalta.' '.$dsr.' '.$ddsr.' '.$folgas.' '.
                                    $thtrab.' '.$thabon.' '.$thdeb.'--------------';
                    break;
                case "Banco de Horas":
                    $k=++$i;
                    $santer = $campos[$k][2];
                    $k=$k+2;
                    $rc=$campos[$k][1];
                    $rd=$campos[$k][3];
                    $rs=$campos[$k][5];
                    $k=$k+2;
                    $ac=$campos[$k][1];
                    $ad=$campos[$k][3];
                    $as=$campos[$k][5];
                    echo '<br>' . $k . ' => '.$santer .' '.$rc.' '.$rd.' '.$rs.' '.$ac.' '.
                                    $ad.' '.$as.'--------------';
                    break;
                    
            }
            if (str_contains($campos[$i][0],'iPonto') && $nome != null){
                echo '<br>' . $i . 'Fim de => '.$reg.':' .$nome;
                $nome = null;
                $reg = null;
            }         
            
        }
    }
    
    public function isRegistroOK($h1,$h2){
        $soma = 0;
        if(!empty($h1)){
            list($ht,$mt) = explode(':', $h1);
            $soma += abs($ht*3600 + $mt*60);                               
         }
         if (!empty($h2)){
              list($hd,$md) = explode(':', $h2); 
              $soma += abs($hd*3600 + $md*60);
         }
         return $soma - 8*3600;
    }
    
    public function CriarFuncionarioByExcel($filename){
        $campos = $this->existFile($filename);
        $nlines = count($campos);
        $nome = null;
        $reg = null;
        for ($i=0; $i<$nlines; $i++){
            switch ($campos[$i][0]){                
                case "Crachá:": 
                    $reg = (int) ($campos[$i][1]); 
                    break;
                case "Nome:": 
                    $nome = $campos[$i][1];
                    $funcionario = Funcionario::find($reg);
                    if (empty($funcionario)){
                        $funcionario = new Funcionario();
                        $funcionario->id = $reg;
                        $funcionario->nome = $nome;
                        $funcionario->ativo = TRUE;
                        $funcionario->user_id = 2;
                        $funcionario->save();
                    }
                    
                    //echo "<br> Funcionário: ".$funcionario->id.' '. $funcionario->nome. 'Criado com sucesso!';
                    break;
            }
        }
        return null;
    }
    
    public function CriarUsuariosByExcel($filename){
        $campos = $this->existFile($filename);
        $nlines = count($campos);
        $nome = null;
        $reg = null;
        for ($i=0; $i<$nlines; $i++){
            switch ($campos[$i][0]){                
                case "Nome:": 
                    $nome = $campos[$i][1];
                    $n = explode(" ", $nome);
                    
                   
                    $login = strtolower($n[0]);
                    $query = User::where('login', 'like', $login.'%')->get();
                    $num = count($query);
                    if (!($num<1)){
                        $login=$login.$num;
                    }
                    $usuario = new User();
                    $usuario->name = $nome;
                    $usuario->login = $login;
                    $usuario->ativo = TRUE;
                    $usuario->password = bcrypt("123");
                    $usuario->save(); 
                    
                    $user2 = User::where('login', '=', $login)->get()->first();
                    $funcionario = Funcionario::where('nome', '=',$nome )->get()->first();
                    
                    $funcionario->user_id = $user2->id;
                    $funcionario->save();

                    break;
                    
            }
        }
        return null;
    }
    
    public function ImportarDesenhosExcel($filename){
        $campos = $this->existFile($filename);
        
        
        return $campos;
    }
}
