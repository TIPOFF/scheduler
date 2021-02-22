<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Scheduler\Models\ScheduleEraser;
use Tipoff\Support\Contracts\Models\UserInterface;

class ScheduleEraserPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view blocks') ? true : false;
    }

    public function view(UserInterface $user, ScheduleEraser $scheduleEraser): bool
    {
        return $user->hasPermissionTo('view blocks') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create blocks') ? true : false;
    }

    public function update(UserInterface $user, ScheduleEraser $scheduleEraser): bool
    {
        return $user->hasPermissionTo('update blocks') ? true : false;
    }

    public function delete(UserInterface $user, ScheduleEraser $scheduleEraser): bool
    {
        return $user->hasPermissionTo('update blocks') ? true : false;
    }

    public function restore(UserInterface $user, ScheduleEraser $scheduleEraser): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, ScheduleEraser $scheduleEraser): bool
    {
        return false;
    }
}
