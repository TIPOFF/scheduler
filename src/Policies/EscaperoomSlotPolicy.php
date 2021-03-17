<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Scheduler\Models\EscaperoomSlot;
use Tipoff\Support\Contracts\Models\UserInterface;

class EscaperoomSlotPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view slots') ? true : false;
    }

    public function view(UserInterface $user, EscaperoomSlot $slot): bool
    {
        return $user->hasPermissionTo('view slots') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create slots') ? true : false;
    }

    public function update(UserInterface $user, EscaperoomSlot $slot): bool
    {
        return $user->hasPermissionTo('update slots') ? true : false;
    }

    public function delete(UserInterface $user, EscaperoomSlot $slot): bool
    {
        return $user->hasPermissionTo('delete slots') ? true : false;
    }

    public function restore(UserInterface $user, EscaperoomSlot $slot): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, EscaperoomSlot $slot): bool
    {
        return false;
    }
}
