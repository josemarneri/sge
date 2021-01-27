<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class UserPolicy
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
    
    public function updateUser(User $user ,User $otherUser){
           $roles = $user->roles()->get();
           foreach($roles as $role){
               $permissions = DB::select('select * from permissions, permission_role'
                   . ' where permissions.id = permission_role.permission_id '
                   . 'and permission_role.role_id = '.$role->id);
               foreach($permissions as $permission){
                   if ($permission->name === "update-user"){
                       return true;
                   }
               }
           }
       return false;
    }
    
    public function changePassword(User $user ,User $otherUser){
       if ($user->id == $otherUser->id){
           return true;
       }
       return false;
    }
    
    public function listUser(User $user){
           $roles = $user->roles()->get();
           foreach($roles as $role){
               $permissions = DB::select('select * from permissions, permission_role'
                   . ' where permissions.id = permission_role.permission_id '
                   . 'and permission_role.role_id = '.$role->id);
               foreach($permissions as $permission){
                   //var_dump($permission);
                   if ($permission->name === "list-user"){
                       return true;
                   }
               }
           }
       return false;
    }
    
    public function saveUser(User $user){
           $roles = $user->roles()->get();
           foreach($roles as $role){
               $permissions = DB::select('select * from permissions, permission_role'
                   . ' where permissions.id = permission_role.permission_id '
                   . 'and permission_role.role_id = '.$role->id);
               foreach($permissions as $permission){
                   //var_dump($permission);
                   if ($permission->name === "save-user"){
                       return true;
                   }
               }
           }
       return false;
    }
    
    public function deleteUser(User $user){
           $roles = $user->roles()->get();
           foreach($roles as $role){
               $permissions = DB::select('select * from permissions, permission_role'
                   . ' where permissions.id = permission_role.permission_id '
                   . 'and permission_role.role_id = '.$role->id);
               foreach($permissions as $permission){
                   //var_dump($permission);
                   if ($permission->name === "delete-user"){
                       return true;
                   }
               }
           }
       return false;
    }
    
    public function createUser(User $user){
           $roles = $user->roles()->get();
           foreach($roles as $role){
               $permissions = DB::select('select * from permissions, permission_role'
                   . ' where permissions.id = permission_role.permission_id '
                   . 'and permission_role.role_id = '.$role->id);
               foreach($permissions as $permission){
                   //var_dump($permission);
                   if ($permission->name === "create-user"){
                       return true;
                   }
               }
           }
       return false;
    }
    
    public function isAtivo(User $user){
        return $user->ativo;
    }

}
