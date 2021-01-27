<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Proposta;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropostaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the proposta.
     *
     * @param  \App\User  $user
     * @param  \App\Proposta  $proposta
     * @return mixed
     */
    public function view(User $user, Proposta $proposta)
    {
        //
    }

    /**
     * Determine whether the user can create propostas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the proposta.
     *
     * @param  \App\User  $user
     * @param  \App\Proposta  $proposta
     * @return mixed
     */
    public function update(User $user, Proposta $proposta)
    {
        //
    }

    /**
     * Determine whether the user can delete the proposta.
     *
     * @param  \App\User  $user
     * @param  \App\Proposta  $proposta
     * @return mixed
     */
    public function delete(User $user, Proposta $proposta)
    {
        //
    }
}
