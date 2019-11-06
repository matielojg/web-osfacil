<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function onlyManagersView(User $user)
    {
        return in_array($user->function, [
            'gerente',
            'supervisor'
        ]);
    }

    public function onlyManagerView(User $user)
    {
        return in_array($user->function, [
            'gerente'
        ]);
    }

    public function onlySupervisorView(User $user)
    {
        return in_array($user->function, [
            'supervisor'
        ]);
    }

    public function onlyTechnicalView(User $user)
    {
        return in_array($user->function, [
            'tecnico',
        ]);
    }
    public function onlyEmployeeView(User $user)
    {
        return in_array($user->function, [
            'funcionario',
        ]);
    }
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->function, [
            'supervisor',
            'gerente'
        ]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
