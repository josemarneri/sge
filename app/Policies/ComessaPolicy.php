<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comessa;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComessaPolicy
{
    use HandlesAuthorization;

    
    public function listComessacoordenador(User $user, Comessa $comessa)
    {
        return $this->isOwner($user,$comessa) ;
    }
    
    public function isOwner(User $user, Comessa $comessa)
    {
        $coordenador=$user->getFuncionario($user->id);
        if(count($comessa->getByCoordenador($coordenador->id))==0){
            return false;
        }else{
            return true;
        }
    }
    
    public function hasPermission(User $user, $permission)
    {
        $roles = $user->roles()->get();
           foreach($roles as $role){
               $permissions = DB::select('select * from permissions, permission_role'
                   . ' where permissions.id = permission_role.permission_id '
                   . 'and permission_role.role_id = '.$role->id);
               foreach($permissions as $p){
                   if ($p->name === $permission){
                       return true;
                   }
               }
           }
       return false;
    }
    
    public function saveEquipe(User $user, Comessa $comessa){
        return $this->isOwner($user, $comessa) || $this->hasPermission($user, 'save-equipe');
    }
    
    public function createEquipe(User $user, Comessa $comessa){
        return $this->isOwner($user, $comessa) || $this->hasPermission($user, 'create-equipe');
    }
}
