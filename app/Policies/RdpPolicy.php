<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rdp;
use Illuminate\Auth\Access\HandlesAuthorization;

class RdpPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the rdp.
     *
     * @param  \App\User  $user
     * @param  \App\Rdp  $rdp
     * @return mixed
     */
    public function view(User $user, Rdp $rdp)
    {
        //
    }

    /**
     * Determine whether the user can create rdps.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the rdp.
     *
     * @param  \App\User  $user
     * @param  \App\Rdp  $rdp
     * @return mixed
     */
    public function update(User $user, Rdp $rdp)
    {
        //
    }

    /**
     * Determine whether the user can delete the rdp.
     *
     * @param  \App\User  $user
     * @param  \App\Rdp  $rdp
     * @return mixed
     */
    public function delete(User $user, Rdp $rdp)
    {
        //
    }
}
