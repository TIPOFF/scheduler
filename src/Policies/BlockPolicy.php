<?php

namespace Tipoff\Scheduling\Policies;

use Tipoff\Scheduling\Models\Block;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlockPolicy
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
     * @param  \App\Block  $block
     * @return mixed
     */
    public function view(User $user, Block $block)
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
     * @param  \App\Block  $block
     * @return mixed
     */
    public function update(User $user, Block $block)
    {
        return $user->hasPermissionTo('update blocks') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Block  $block
     * @return mixed
     */
    public function delete(User $user, Block $block)
    {
        return $user->hasPermissionTo('update blocks') ? true : false;
    }
}
