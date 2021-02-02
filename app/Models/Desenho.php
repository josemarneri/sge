<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;//classe responsável pela manipulação da planilha
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //classe que salvará a planilha em .xlsx
use App\Models\Conjunto;
use App\Models\Projeto;


class Desenho extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','numero', 'alias', 'descricao','material','peso','tratamento','observacoes', 'projeto_id', 'user_id' ];
    
    function __construct() {
        $this->numero = $this->gerarNumero();
        $this->alias = $this->numero;
    }

    
    function getFillable() {
        return $this->fillable;
    }

    function setFillable($fillable) {
        $this->fillable = $fillable;
    }
    
    function getCodigoProjeto($projeto_id){
        $projeto = Projeto::find($projeto_id);
        return (!empty($projeto))? $projeto->codigo : null;
    }
    
    function getByNumero($numero) {
        $desenho = Desenho::where('numero','=',$numero)->first();
        return $desenho;
    }
    function getById($id) {
        $desenho = Desenho::where('id','=',$id)->first();
        return $desenho;
    }
    function getNumeroById($id) {
        $desenho = Desenho::where('id','=',$id)->first();
        return $desenho->numero;
    }
    
    function getPais() {
        $conjuntos = DB::table('conjuntos')
                    ->where('filho_id', '=', $this->id)->get()->all();;

        return $conjuntos;
    }
    function getFilhos() {
        $conjuntos = DB::table('conjuntos')
                    ->where('pai_id', '=', $this->id)->get()->all();;

        return $conjuntos;
    }
    function getConjuntos() {
        $conjuntos = DB::table('conjuntos')
                    ->where('pai_id', '=', $this->id)
                    ->orWhere('filho_id','=',$this->id)
                ->get()->all();

        return $conjuntos;
    }
    
    public function getDesenhos($filtro) {
        //$numero = empty($filtro['numero'])?'*':$filtro['numero'];
        $desenhos = DB::table('desenhos')
                    ->where([
                        ['numero', '=', empty($filtro['numero'])?'*':$filtro['numero']],               
                    ])->get();

        return $desenhos;
    }
    public function Filtrar($filtro){
        
        $desenhos = DB::table('desenhos');
        $projeto = new Projeto();

        $resultado;
        if(!empty($filtro['filtronumero'])){
            $desenhos->where('numero','=',$filtro['filtronumero']);
        }
        if(!empty($filtro['filtropai'])){
            $desenhos->where('pai','=',$filtro['filtropai']);
        }
        if(!empty($filtro['filtroalias'])){
            $desenhos->where('alias','=',$filtro['filtroalias']);
        }
        if(!empty($filtro['filtrodescricao'])){
            $desenhos->where('descricao','like','%'.$filtro['filtrodescricao'].'%');
        }
        if(!empty($filtro['filtromaterial'])){
            $desenhos->where('material','like','%'.$filtro['filtromaterial'].'%');
        }        
        if(!empty($filtro['filtroprojeto_id'])){
                $desenhos->where('projeto_id','=',$filtro['filtroprojeto_id']);           
            //$desenhos->take($filtro['maxresult']);             
        }
        if(empty($filtro['filtroordem'])){
            $desenhos->inRandomOrder();
        }else{
            foreach($filtro['filtroordem'] as $key=>$valor){
                $desenhos->orderBy($key,$valor);
            }            
        } 
        
        $desenhos = $desenhos->get()->all(); 
        foreach($desenhos as $d){
           $resultado[$d->id]=$this->find($d->id); 
           
        }
        return (empty($resultado))? null : $resultado;
        //return $resultado;
        
    }
    
    public function gerarNumero(){
        
        $data = date('ymd');
        $lista = DB::table('desenhos')
                ->where('numero', '>',  $data)
                ->orderBy('numero', 'desc')
                ->get();
        if (count($lista)<1){
            $numero = $data . '000';
            //echo $numero + '/n';
            return $numero;
        }
        $numero = $lista[0]->numero; 
        //echo $numero +1;
        return $numero + 1;
        
    }
    
    public function pegarData(){
        $data = date('ymd');
        dd($data);
        return $data;
    }
    
    public function getAnexos($id){
        $arquivo = new Arquivo();
        $anexos = $arquivo->ListarDeById('desenhos', $id);
        return $anexos;
    }
    
    public function addfilhos($filhos) {       
        if(empty($filhos)){
            return 0;
        }
        foreach($filhos as $f){
            $this->addfilho($f);                          
        }  
        return 1;
    }
    public function addfilho($f) {       
        if(empty($f)){
            return 0;
        }               
        $conjunto = new Conjunto();
        $filho = $this->getByNumero($f);
        if(!empty($filho)){
            $existe = Conjunto::where('pai_id','=',$this->id)
                    ->where('filho_id','=', $filho->id)->first();
            if (empty($existe)){
               $conjunto->pai_id = $this->id; 
                $conjunto->filho_id = $filho->id;
                $conjunto->save(); 
            } else return 0;                
        }                 
        return 1;
    }
    public function addpais($pais) {       
        if(empty($pais)){
            return 0;
        }
        foreach($pais as $p){
            $this->addpai($p);                     
        }  
        return 1;
    }
    public function addpai($p) {       
        if(empty($p)){
            return 0;
        }
        if(!empty($p)){                
            $conjunto = new Conjunto();
            $pai = $this->getByNumero($p);
            if(!empty($pai)){
                 $existe = Conjunto::where('pai_id','=',$pai->id)
                        ->where('filho_id','=', $this->id)->first();
                 if (empty($existe)){
                    $conjunto->filho_id = $this->id; 
                    $conjunto->pai_id = $pai->id;
                    $conjunto->save();
                 }  else return 0;                   
            }                 
        }                            
        return 1;
    }
    
     public function existFile($filename){
        if (!file_exists($filename)) {
                exit("Arquivo não encontrado");
                return null;
        }else{
           // $objPHPExcel = PHPExcel_IOFactory::load($filename);
            $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
            $c0 = $objPHPExcel->getSheet(0)->calculateWorksheetDataDimension();
            $c1 = $objPHPExcel->getSheet(1)->calculateWorksheetDataDimension();
            $campos[0] = $objPHPExcel->getSheet(0)->rangeToArray($c0);
            $campos[1] = $objPHPExcel->getSheet(1)->rangeToArray($c1);
            return $campos;
        }
        
        //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('phpcomexcel.xlsx');
    }
    
    public function ImportarDesenhosExcel($filename){
        $campos = $this->existFile($filename);
        
        
        return $campos;
    }
}
