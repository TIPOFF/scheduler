<?php

namespace Tipoff\Scheduling\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Scheduling\Models\Slot;

class SlotPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view slots') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Slot  $slot
     * @return mixed
     */
    public function view(User $user, Slot $slot)
    {
        return $user->hasPermissionTo('view slots') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create slots') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Slot  $slot
     * @return mixed
     */
    public function update(User $user, Slot $slot)
    {
        return $user->hasPermissionTo('update slots') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Slot  $slot
     * @return mixed
     */
    public function delete(User $user, Slot $slot)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Slot  $slot
     * @return mixed
     */
    public function restore(User $user, Slot $slot)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Slot  $slot
     * @return mixed
     */
    public function forceDelete(User $user, Slot $slot)
    {
        return false;
    }
}