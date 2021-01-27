<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Diariodebordo;

class DiariodebordoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the diariodebordo.
     *
     * @param  \App\User  $user
     * @param  \App\Diariodebordo  $diariodebordo
     * @return mixed
     */
    public function listDiariodebordo(User $user, Diariodebordo $diariodebordo)
    {
        return true;
    }

    /**
     * Determine whether the user can create diariodebordos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function createDiariodebordo(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the diariodebordo.
     *
     * @param  \App\User  $user
     * @param  \App\Diariodebordo  $diariodebordo
     * @return mixed
     */
    public function updateDiariodebordo(User $user, Diariodebordo $diariodebordo)
    {
        return $this->isOwner($user, $diariodebordo);
    }

    /**
     * Determine whether the user can delete the diariodebordo.
     *
     * @param  \App\User  $user
     * @param  \App\Diariodebordo  $diariodebordo
     * @return mixed
     */
    public function deleteDiariodebordo(User $user, Diariodebordo $diariodebordo)
    {
        return $this->isOwner($user, $diariodebordo);
    }

    /**
     * Determine whether the user can delete the diariodebordo.
     *
     * @param  \App\User  $user
     * @param  \App\Diariodebordo  $diariodebordo
     * @return mixed
     */
    public function saveDiariodebordo(User $user, Diariodebordo $diariodebordo)
    {
        return $this->isOwner($user, $diariodebordo);
    }
    
    public function isOwner(User $user, Diariodebordo $diariodebordo)
    {
        if($diariodebordo->getFuncionario()->user_id== $user->id){
            return true;
        }
        return false;
    }
    
}
