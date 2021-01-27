<?php

namespace App\Http\Controllers\Util;

use Request;
use App\Http\Controllers\Controller;
use App\Others\PontoExcel;

class UtilController extends Controller
{
    //
    public function index()
    {
        return view('util.util');
    }
    
    public function CreateUserFromExcel(){
        //Selecionar um arquivo
        $file = Request::file('filefield');
        $users = new PontoExcel();
        $users->CriarUsuariosByExcel($file->getPathname());
        
        return redirect('/painel/usuarios');
        
    }
    
        
    
    public function CreateFuncionarioFromExcel() {
        $file = Request::file('filefield');
        $ponto = new PontoExcel();
        $ponto->CriarFuncionarioByExcel($file->getPathname());
        \Session::flash('mensagem_sucesso', "Funcionários criados com sucesso!!!");
        return redirect('/painel/funcionarios');
    }
}
