<?php

namespace App\Http\Controllers\Painel;

use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Rdp;
use App\Others\PontoExcel;

class RdpController extends Controller
{
    //
    
    public function Rdp() {
        $func_id = 12;
        $data = '01/01/2017';
        $df = \DateTime::createFromFormat('d/m/Y', $data);
        $df = $df->format('Y-m-d');
        $report = Rdp::where('funcionario_id','=',$func_id)
                ->where('data','=', $df)
                ->first();
        return $report;
    }
    
    public function index() {
        return view('painel.rdp.rdp');
    }
    
    public function ImportFromExcelToDB() {
        //Selecionar um arquivo
        $file = Request::file('filefield');
        $ponto = new PontoExcel();
        $ponto->ReadExcel($file->getPathname());
        return null;
        
    }
    
    public function Carregar() { 
            $file = Request::file('filefield');
            $nome = $file->getClientOriginalName();//Request::get('nome');
            $extension = $file->getClientOriginalExtension();
            Storage::disk('local')->put($nome,  File::get($file));
            $arquivo = new Arquivo();
            $arquivo->mime = $file->getClientMimeType();
            $arquivo->nomearquivo = $file->getClientOriginalName();
            $arquivo->nome = $nome;

            $arquivo->save();

            return redirect('arquivos');

    }
}
