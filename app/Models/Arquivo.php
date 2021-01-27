<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class Arquivo extends Model
{
    //
    protected $fillable = [
        'id','nome', 'mime','nomearquivo','anexode', 'from_id',
    ];

    public function ListarDe($anexode){
        $arquivos = Arquivo::where('anexode', '=', $anexode)->get();
        return $arquivos;
    }
    
    public function ListarDeById($anexode, $id){
        $arquivos = Arquivo::where('anexode', '=', $anexode)
                ->where('from_id','=', $id)
                ->get();
        //dd($arquivos);
        return $arquivos;
    }
    
    public function createDir($dirname){
        $files = Storage::allFiles('/');
        $teste = in_array("$dirname/", $files);
        if(!$teste){
            Storage::makeDirectory("$dirname/");
        }
    }
    
    public function getDirs($dir) {
        //$files = Storage::files($dir);

        $files = Storage::allFiles($dir);
        foreach($files as $file){
            $teste1[]=$file;
            $teste[] = strpos($file, 'ativ');
            $teste2[] = str_contains($file, 'public/');
        }
        $teste3 = in_array('Atividades/', $files);
        if(!$teste3){
            Storage::makeDirectory('Atividades');
        }
        dd($teste1,$teste, $teste2);        
    }
}