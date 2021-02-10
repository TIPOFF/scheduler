<?php

namespace Tipoff\Scheduling\Policies;

use Tipoff\Scheduling\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
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
        return $user->hasPermissionTo('view games') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function view(User $user, Game $game)
    {
        return $user->hasPermissionTo('view games') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function update(User $user, Game $game)
    {
        return $user->hasPermissionTo('update games') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function delete(User $user, Game $game)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function restore(User $user, Game $game)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function forceDelete(User $user, Game $game)
    {
        return false;
    }
}
