<?php

namespace App\Http\Controllers\Util;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Others\SimpleXLSX;

use App\Others\PontoExcel;

class ExcelController extends Controller
{
    public function index(){
        $xlsx = new SimpleXLSX('assets/support/excel1.xlsx');
       // print_r( $xlsx->rows() );
       // print_r( $xlsx->rowsEx() );
        //print_r( $xlsx->rows(2) ); // second worksheet
       // dd($xlsx->sheets());
//        foreach($xlsx->rows() as $chave => $valor){
//            echo "<br>$chave:  ";
//            foreach($valor as $v){
//                echo "$v";
//            }
//        }
//        echo count($xlsx->sheets());
//        echo '<h1>$xlsx->rows()</h1>';
//        echo '<pre>';
//        print_r( $xlsx->rows() );
//        echo '</pre>';
        
        return "<br> ok";
    }
    
    public function test($id=null){
        $t = (double) $id;
        
        dd($t);
            
        
    }

}
