<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RestaurantPolicy
{
     use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('Read-Restaurant')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restaurant $restaurant)
    {
        return $user->hasPermissionTo('Read-Restaurant')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('Create-Restaurant')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restaurant $restaurant)
    {
        return $user->hasPermissionTo('Update-Restaurant')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        return $user->hasPermissionTo('Delete-Restaurant')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Restaurant $restaurant)
    {
        return $user->hasPermissionTo('Trashed-Restaurant')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Restaurant $restaurant): bool
    {
        //
    }
}
