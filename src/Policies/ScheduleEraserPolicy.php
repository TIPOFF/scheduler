<?php

namespace Tipoff\Scheduling\Policies;

use Tipoff\Scheduling\Models\ScheduleEraser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScheduleEraserPolicy
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
        return $user->hasPermissionTo('view blocks') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ScheduleEraser  $scheduleEraser
     * @return mixed
     */
    public function view(User $user, ScheduleEraser $scheduleEraser)
    {
        return $user->hasPermissionTo('view blocks') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create blocks') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ScheduleEraser  $scheduleEraser
     * @return mixed
     */
    public function update(User $user, ScheduleEraser $scheduleEraser)
    {
        return $user->hasPermissionTo('update blocks') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ScheduleEraser  $scheduleEraser
     * @return mixed
     */
    public function delete(User $user, ScheduleEraser $scheduleEraser)
    {
        return $user->hasPermissionTo('update blocks') ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ScheduleEraser  $scheduleEraser
     * @return mixed
     */
    public function restore(User $user, ScheduleEraser $scheduleEraser)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ScheduleEraser  $scheduleEraser
     * @return mixed
     */
    public function forceDelete(User $user, ScheduleEraser $scheduleEraser)
    {
        return false;
    }
}
