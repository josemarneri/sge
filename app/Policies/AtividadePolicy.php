<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Atividade;
use App\Models\Comessa;
use Illuminate\Auth\Access\HandlesAuthorization;

class AtividadePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the atividade.
     *
     * @param  \App\User  $user
     * @param  \App\Atividade  $atividade
     * @return mixed
     */
    public function listAtividade(User $user, Atividade $atividade)
    {
        //
    }

    /**
     * Determine whether the user can create atividades.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function createAtividade(User $user, Atividade $atividade)
    {
        return $this->isOwner($user,$atividade) || 
                $this->hasComessa($user) || 
                $user->hasPermissionByName($user, 'create-atividade');
    }
    
    /**
     * Determine whether the user can save atividades.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function saveAtividade(User $user, Atividade $atividade)
    {
        return $this->isOwner($user,$atividade) || 
                $user->hasPermissionByName($user, 'save-atividade');
    }
    
    /**
     * Determine whether the user can save atividades.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function executarAtividade(User $user, Atividade $atividade)
    {
        return $this->isExecutor($user,$atividade) || 
                $user->hasPermissionByName($user, 'save-atividade');
    }
    
    /**
     * Determine whether the user can save atividades.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function avaliarAtividade(User $user, Atividade $atividade)
    {
        dd('avaliar-atividade policy');
        return $this->isOwner($user,$atividade) || $user->hasPermissionByName($user, 'avaliar-atividade');
    }
    
    
    
    public function isOwner(User $user, Atividade $atividade)
    {
        if(empty($atividade->comessa_id)){
            return false;
        }
        if($atividade->getOwnerComessa()->user_id == $user->id){
            return true;
        }else{
            return false;
        }
    }
    
    public function hasComessa(User $user)
    {
        $coordenador = $user->getFuncionario($user->id);
        $comessa = new Comessa();
        $comessas = $comessa->getByCoordenador($coordenador->id);
        if(count($comessas)>0){
            return true;
        }else{
            return false;
        }
    }
    
    
    public function isExecutor(User $user, Atividade $atividade)
    {
        if(empty($atividade->funcionario_id)){
            return false;
        }
        if($atividade->getFuncionario()->user_id == $user->id){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can update the atividade.
     *
     * @param  \App\User  $user
     * @param  \App\Atividade  $atividade
     * @return mixed
     */
    public function updateAtividade(User $user, Atividade $atividade)
    {
        return $this->isOwner($user,$atividade) || $user->hasPermissionByName($user, 'update-atividade');
    }

    /**
     * Determine whether the user can delete the atividade.
     *
     * @param  \App\User  $user
     * @param  \App\Atividade  $atividade
     * @return mixed
     */
    public function deleteAtividade(User $user, Atividade $atividade)
    {
        return $this->isOwner($user,$atividade) || $user->hasPermissionByName($user, 'delete-atividade');
    }
}
