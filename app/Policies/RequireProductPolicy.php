<?php

namespace App\Policies;

use App\Models\RequireProduct;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequireProductPolicy
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
     * @param \App\Models\RequireProduct $requireProduct
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can attach models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function attach(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can attach models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAttachment(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RequireProduct $requireProduct
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RequireProduct $requireProduct
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, RequireProduct $requireProduct)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RequireProduct $requireProduct
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, RequireProduct $requireProduct)
    {
        //
    }
}
