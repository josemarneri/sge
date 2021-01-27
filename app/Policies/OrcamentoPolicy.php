<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Orcamento;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrcamentoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the orcamento.
     *
     * @param  \App\User  $user
     * @param  \App\Orcamento  $orcamento
     * @return mixed
     */
    public function view(User $user, Orcamento $orcamento)
    {
        //
    }

    /**
     * Determine whether the user can create orcamentos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the orcamento.
     *
     * @param  \App\User  $user
     * @param  \App\Orcamento  $orcamento
     * @return mixed
     */
    public function update(User $user, Orcamento $orcamento)
    {
        //
    }

    /**
     * Determine whether the user can delete the orcamento.
     *
     * @param  \App\User  $user
     * @param  \App\Orcamento  $orcamento
     * @return mixed
     */
    public function delete(User $user, Orcamento $orcamento)
    {
        //
    }
}
