<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Scheduling\Models\Block;
use Tipoff\Support\Contracts\Models\UserInterface;

class BlockPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view blocks') ? true : false;
    }

    public function view(UserInterface $user, Block $block): bool
    {
        return $user->hasPermissionTo('view blocks') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create blocks') ? true : false;
    }

    public function update(UserInterface $user, Block $block): bool
    {
        return $user->hasPermissionTo('update blocks') ? true : false;
    }

    public function delete(UserInterface $user, Block $block): bool
    {
        return $user->hasPermissionTo('delete blocks') ? true : false;
    }
}
