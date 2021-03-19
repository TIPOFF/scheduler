<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Scheduler\Models\EscaperoomGame;
use Tipoff\Support\Contracts\Models\UserInterface;

class EscaperoomGamePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view games') ? true : false;
    }

    public function view(UserInterface $user, EscaperoomGame $game): bool
    {
        return $user->hasPermissionTo('view games') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return false;
    }

    public function update(UserInterface $user, EscaperoomGame $game): bool
    {
        return $user->hasPermissionTo('update games') ? true : false;
    }

    public function delete(UserInterface $user, EscaperoomGame $game): bool
    {
        return false;
    }

    public function restore(UserInterface $user, EscaperoomGame $game): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, EscaperoomGame $game): bool
    {
        return false;
    }
}
