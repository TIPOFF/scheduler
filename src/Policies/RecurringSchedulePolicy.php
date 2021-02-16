<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Scheduling\Models\RecurringSchedule;
use Tipoff\Support\Contracts\Authorization\UserInterface;

class RecurringSchedulePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view schedules') ? true : false;
    }

    public function view(UserInterface $user, RecurringSchedule $recurringSchedule): bool
    {
        return $user->hasPermissionTo('view schedules') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create schedules') ? true : false;
    }

    public function update(UserInterface $user, RecurringSchedule $recurringSchedule): bool
    {
        return $user->hasPermissionTo('update schedules') ? true : false;
    }

    public function delete(UserInterface $user, RecurringSchedule $recurringSchedule): bool
    {
        return $user->hasPermissionTo('delete schedules') ? true : false;
    }
}
