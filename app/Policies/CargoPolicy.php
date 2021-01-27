<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cargo;
use Illuminate\Auth\Access\HandlesAuthorization;

class CargoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the cargo.
     *
     * @param  \App\User  $user
     * @param  \App\Cargo  $cargo
     * @return mixed
     */
    public function view(User $user, Cargo $cargo)
    {
        //
    }

    /**
     * Determine whether the user can create cargos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the cargo.
     *
     * @param  \App\User  $user
     * @param  \App\Cargo  $cargo
     * @return mixed
     */
    public function update(User $user, Cargo $cargo)
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
    public function delete(User $user, Cargo $cargo)
    {
        //
    }
}
