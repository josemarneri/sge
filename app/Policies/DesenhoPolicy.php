<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesenhoPolicy
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
    public function listDesenho(User $user, Cargo $cargo)
    {
        //
    }

    /**
     * Determine whether the user can create cargos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function changeDesenho(User $user)
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
    public function deleteDesenho(User $user, Cargo $cargo)
    {
        //
    } 
    
}
