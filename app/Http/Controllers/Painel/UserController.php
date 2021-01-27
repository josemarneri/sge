<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use App\Models\User;

class UserController extends Controller
{
     //
    private $user;
    
    public function __construct(User $user){
        $this->user = $user;
    }
    
    public function index(){
        if (Gate::denies('list-user')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $users = $this->user->all();
        
        return view('painel.usuarios.usuarios', compact('users'));
    }
    
    public function Atualizar($iduser){
        $user = User::find($iduser);
        if (Gate::denies('update-user', $user)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        return view('painel.usuarios.novousuario', compact('user'));
    }
    
    public function AlterarSenha($iduser){
        $user = User::find($iduser);
        if (Gate::denies('update-password', $user)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        return view('painel.usuarios.alterarsenha', compact('user'));
    }
    
    public function Novo(){
        if (Gate::denies('create-user')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $user = new User(); 
        
        return view('painel.usuarios.novousuario', compact('user'));
    }
    
    public function Apagar($iduser){
        if (Gate::denies('delete-user')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $user = User::find($iduser);        
        $user->delete();
        return redirect('/painel/usuarios');
    }
    
    public function AtivarDesativar($iduser){
        if (Gate::denies('update-user')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $user = User::find($iduser);
        $user->ativo = ($user->ativo==1) ? 0 : 1; 
        $user->save();
        return redirect('/painel/usuarios');
    }
    
    public function Salvar(Request $request){
        if (Gate::denies('save-user')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if ($request->get('id')){ 
            $id = $request->get('id');
            $user = User::find($id);
            $user->name = $request->get('name');
            $user->login = $request->get('login');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->ativo = $request->get('ativo');
            $user->save();
            \Session::flash('mensagem_sucesso', "Usuario ".$user->name." atualizado com sucesso ");
        }else {
            $user = new User();
            $user->name = $request->get('name');
            $user->login = $request->get('login');
            $user->password = bcrypt($request->get('password'));
            $user->email = $request->get('email');
            $user->ativo = 1;
            $user->save();
            \Session::flash('mensagem_sucesso', 'Usuario cadastrado com sucesso');
        }  
        return redirect('/painel/usuarios/novo');
    }
    public function SalvarNovaSenha(Request $request){
            $id = $request->get('id');
            $user = User::find($id);
        if (Gate::denies('update-password',$user)){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
            $user->name = $request->get('name');
            $user->login = $request->get('login');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->save();
            \Session::flash('mensagem_sucesso', "Senha de ".$user->name." atualizada com sucesso ");
        return \Redirect::back();
    }   
    
}
