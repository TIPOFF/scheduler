<?php

namespace Tipoff\Scheduling\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Scheduling\Models\RecurringSchedule;

class RecurringSchedulePolicy
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
        return $user->hasPermissionTo('view schedules') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecurringSchedule  $recurringSchedule
     * @return mixed
     */
    public function view(User $user, RecurringSchedule $recurringSchedule)
    {
        return $user->hasPermissionTo('view schedules') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create schedules') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecurringSchedule  $recurringSchedule
     * @return mixed
     */
    public function update(User $user, RecurringSchedule $recurringSchedule)
    {
        return $user->hasPermissionTo('update schedules') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecurringSchedule  $recurringSchedule
     * @return mixed
     */
    public function delete(User $user, RecurringSchedule $recurringSchedule)
    {
        return $user->hasPermissionTo('delete schedules') ? true : false;
    }
}
