<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('Read-items')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Item $item)
    {
        return $user->hasPermissionTo('Read-items')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('Create-Item')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Item $item)
    {
        return $user->hasPermissionTo('Update-Item')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Item $item)
    {
        return $user->hasPermissionTo('Delete-Item')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Item $item)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Item $item)
    {
        //
    }
}
