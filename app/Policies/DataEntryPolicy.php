<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DataEntryPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('Read-DataEntry')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission To Data Entry',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model)
    {
        return $user->hasPermissionTo('Read-DataEntry')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('Create-DataEntry')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model)
    {
        return $user->hasPermissionTo('Update-DataEntry')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model)
    {
        return $user->hasPermissionTo('Delete-DataEntry')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
