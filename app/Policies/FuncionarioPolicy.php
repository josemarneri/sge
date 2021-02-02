<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Funcionario;
use Illuminate\Auth\Access\HandlesAuthorization;

class FuncionarioPolicy
{
    use HandlesAuthorization;
    
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine whether the user can view the funcionario.
     *
     * @param  \App\User  $user
     * @param  \App\Funcionario  $funcionario
     * @return mixed
     */
    public function listFuncionario(User $user)
    {
       // return $this->hasPermission($user, 'list-funcionario');
    }

    /**
     * Determine whether the user can create funcionarios.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function createFuncionario(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the funcionario.
     *
     * @param  \App\User  $user
     * @param  \App\Funcionario  $funcionario
     * @return mixed
     */
    public function updateFuncionario(User $user, Funcionario $funcionario)
    {
        //
    }

    /**
     * Determine whether the user can delete the funcionario.
     *
     * @param  \App\User  $user
     * @param  \App\Funcionario  $funcionario
     * @return mixed
     */
    public function delete(User $user)
    {
        //
    }
    
    /**
     * Determine whether the user can delete the funcionario.
     *
     * @param  \App\User  $user
     * @param  \App\Funcionario  $funcionario
     * @return mixed
     */
    public function updateInformacoes(User $user, Funcionario $funcionario) {
        //dd('aqui');
      if ($user->id == $funcionario->user_id){
           return true;
       }
       return false;
    }
    
    public function hasPermission(User $user, $permission, $other=null)
    {
        $roles = $user->roles()->get();
           foreach($roles as $role){
               $permissions = DB::select('select * from permissions, permission_role'
                   . ' where permissions.id = permission_role.permission_id '
                   . 'and permission_role.role_id = '.$role->id);
               foreach($permissions as $permission){
                   //var_dump($permission);
                   if ($permission->name === $permission){
                       return true;
                   }
               }
           }
       return false;//
        
    }
}
