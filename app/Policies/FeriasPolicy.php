<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ferias;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeriasPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ferias.
     *
     * @param  \App\User  $user
     * @param  \App\ferias  $ferias
     * @return mixed
     */
    public function view(User $user, ferias $ferias)
    {
        //
    }

    /**
     * Determine whether the user can create ferias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the ferias.
     *
     * @param  \App\User  $user
     * @param  \App\ferias  $ferias
     * @return mixed
     */
    public function update(User $user, ferias $ferias)
    {
        //
    }

    /**
     * Determine whether the user can delete the ferias.
     *
     * @param  \App\User  $user
     * @param  \App\ferias  $ferias
     * @return mixed
     */
    public function delete(User $user, ferias $ferias)
    {
        //
    }
}
