<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjetoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function listProjeto(User $user, Cargo $cargo)
    {
        //
    }

    /**
     * Determine whether the user can create cargos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function changeProjeto(User $user)
    {
        //
    }


    /**
     * Determine whether the user can delete the cargo.
     *
     * @param  \App\User  $user
     * @param  \App\Cargo  $cargo
     * @return mixed
     */
    public function deleteProjeto(User $user, Cargo $cargo)
    {
        //
    } 
}
