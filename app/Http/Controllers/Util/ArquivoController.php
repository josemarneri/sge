<?php

namespace App\Http\Controllers\Util;

//use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Arquivo;

class ArquivoController extends Controller
{
    //
    
    	public function index()
	{
		$arquivos = Arquivo::all();

		return view('arquivos.arquivos', compact('arquivos'));
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
        
        public function ListarAnexos($anexode, $from_id = 0){
            $arquivo = new Arquivo();
            $arquivos = $arquivo->ListarDeById($anexode, $from_id);
            return view('arquivos.anexararquivos', compact('arquivos','anexode','from_id'));
            
        }
        
        public function Anexar() { 
            $anexode = $_POST['anexode'];
            $arquivo = new Arquivo();
            $arquivo->createDir($anexode);
            $from_id = $_POST['from_id'];
            $files = Request::file('filefield');
            foreach ($files as $file){
                $nome = $from_id.'_'.$file->getClientOriginalName();//Request::get('nome');
                $extension = $file->getClientOriginalExtension();
                if(Storage::exists($nome)){
                    \Session::flash('mensagem_error', "O Arquivo ".$nome." já foi inserido anteriormente");
                    return redirect('arquivos/anexar/'.$anexode.'/'.$from_id);
                }
                if(Storage::disk('local')->put("$anexode/$nome",  File::get($file))){
                    $arquivo = new Arquivo();
                    $arquivo->mime = $file->getClientMimeType();
                    $arquivo->nomearquivo = $file->getClientOriginalName();
                    $arquivo->nome = "$anexode/$nome";
                    $arquivo->anexode = $anexode;
                    $arquivo->from_id = $from_id; 
                    $arquivo->save();
                    \Session::flash('mensagem_sucesso', "O Arquivo ".$nome." foi inserido com sucesso");
                }else{
                    //criar mensagem de erro!!
                }
                
            }            
            return redirect('arquivos/anexar/'.$anexode.'/'.$from_id);
		
	}
        
        public function Baixar($id){
            $arquivo = Arquivo::find($id);
            //$arquivo = Fileentry::where('filename', '=', $filename)->firstOrFail();
            $file = Storage::disk('local')->get($arquivo->nome);
            //dd(new Response($file, 200))->header('Content-Type', $arquivo->mime);
            return (new Response($file, 200))
                    ->header('Content-Type', $arquivo->mime);
	}
        
        public function Apagar($id){
            $arquivo = Arquivo::find($id);
            
            if(Storage::exists($arquivo->nome)){
                Storage::delete($arquivo->nome);
                $arquivo->delete();
            }else{
                $arquivo->delete();
            }
            return redirect()->back();
	}
        
        
        
}