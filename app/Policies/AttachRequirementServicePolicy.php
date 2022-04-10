<?php

namespace App\Policies;

use App\Models\Requirement;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachRequirementServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isAccess('user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @param \App\Models\Requirement $requirement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Service $service, Requirement $requirement)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @param \App\Models\Requirement $requirement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Service $service, Requirement $requirement)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @param \App\Models\Requirement $requirement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Service $service, Requirement $requirement)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @param \App\Models\Requirement $requirement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Service $service, Requirement $requirement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @param \App\Models\Requirement $requirement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Service $service, Requirement $requirement)
    {
        //
    }
}