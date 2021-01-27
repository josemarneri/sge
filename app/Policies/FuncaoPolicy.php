<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Funcao;
use Illuminate\Auth\Access\HandlesAuthorization;

class FuncaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the funcao.
     *
     * @param  \App\User  $user
     * @param  \App\Funcao  $funcao
     * @return mixed
     */
    public function view(User $user, Funcao $funcao)
    {
        //
    }

    /**
     * Determine whether the user can create funcaos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the funcao.
     *
     * @param  \App\User  $user
     * @param  \App\Funcao  $funcao
     * @return mixed
     */
    public function update(User $user, Funcao $funcao)
    {
        //
    }

    /**
     * Determine whether the user can delete the funcao.
     *
     * @param  \App\User  $user
     * @param  \App\Funcao  $funcao
     * @return mixed
     */
    public function delete(User $user, Funcao $funcao)
    {
        //
    }
}
