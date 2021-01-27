<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
     //
    private $role;
    
    public function __construct(Role $role){
        $this->role = $role;
    }
    
    public function index(){
        if (Gate::denies('list-perfil')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $perfis = $this->role->all();
//        $role = $this->role->find(1);
//        dd($role->getPermissions());
        
        return view('painel.perfis.perfis', compact('perfis'));
    }
    
    public function Atualizar($id){
        $perfil = Role::find($id);
        if (Gate::denies('update-perfil')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $permissoes = Permission::all();
        return view('painel.perfis.novoperfil', compact('perfil','permissoes'));
    }
    
    public function Novo(){
        if (Gate::denies('create-perfil')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $perfil = new Role();
        $permissoes = Permission::all();
        return view('painel.perfis.novoperfil', compact('perfil','permissoes'));
    }
    
    public function Apagar($id){
        if (Gate::denies('delete-perfil')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $perfil = Role::find($id);        
        $perfil->delete();
        return redirect('/painel/perfis');
    }
    
    public function Salvar(Request $request){
        if (Gate::denies('save-perfil')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $permission = new Permission();
        $perfil = Role::find($request->get('id'));
        if ($perfil){
            $permission->limpaPermissoes($perfil->id);
            $permission->addPermissoes($perfil->id, $request['permissoes']);            
            $perfil->fill($request->all()); 
            $perfil->save();
            \Session::flash('mensagem_sucesso', "Perfil ".$perfil->name." atualizado com sucesso ");
        }else {
              $perfil = new Role();
              $request['id']= $perfil->id;
              $perfil->create($request->all());
            \Session::flash('mensagem_sucesso', 'Perfil cadastrado com sucesso');
        }  
        return redirect('/painel/perfis/novo');
    }
    
    public function addUsuario($user_id){
        $user = User::find($user_id);
        if (Gate::denies('update-perfil')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $perfis = Role::all();
        return view('painel.perfis.addusuarioperfil', compact('user','perfis'));
    }
    
    public function SalvarPerfilAdd(Request $request){
        if (Gate::denies('update-perfil')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $user_id = $request->get('user_id');
        $perfis_id = $request->get('perfis');
        $perfil = new Role();
        $perfil->limpaPerfis($user_id);
        $perfil->addPerfis($user_id, $perfis_id);
        
        return redirect('/painel/usuarios');
    }
}
