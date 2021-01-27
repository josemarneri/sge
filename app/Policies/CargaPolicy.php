<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Carga;
use App\Models\Funcionario;
use Illuminate\Auth\Access\HandlesAuthorization;

class CargaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the carga.
     *
     * @param  \App\User  $user
     * @param  \App\Carga  $carga
     * @return mixed
     */
    public function view(User $user, Carga $carga)
    {
        //
    }
    
    /**
     * Determine whether the user can delete the carga.
     *
     * @param  \App\User  $user
     * @param  \App\Carga  $carga
     * @return mixed
     */
    public function listCargaCoordenador(User $user, Carga $carga)
    {
        $coordenador=$user->getFuncionario($user->id);
        if(count($carga->getByCoordenador($coordenador->id))==0){
            return false;
        }else{
            return true;
        }
    }
    
    public function isOwner(User $user, Carga $carga)
    {
        if(empty($carga->getCoordenador())){
            return false;
        }
        if($carga->getCoordenador()->user_id == $user->id){
            return true;
        }else{
            return false;
        }
    }
    
    public function updateCarga(User $user, Carga $carga){ 
        return $this->isOwner($user,$carga) || $user->hasPermissionByName($user, 'update-carga');
    }
    
    public function saveCarga(User $user, Carga $carga){ 
        return $this->isOwner($user,$carga) || $user->hasPermissionByName($user, 'save-carga');
    }

    
}
