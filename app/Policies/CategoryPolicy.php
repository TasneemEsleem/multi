<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('Read-Category')
        ? $this->allow()
        : $this->deny('Sorry Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category)
    {
        return $user->hasPermissionTo('Read-Category')
        ? $this->allow()
        : $this->deny('Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('Create-Category')
        ? $this->allow()
        : $this->deny('Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category)
    {
        return $user->hasPermissionTo('Update-Category')
        ? $this->allow()
        : $this->deny('Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category)
    {
        return $user->hasPermissionTo('Delete-Category')
        ? $this->allow()
        : $this->deny('Don\'t have Permission',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category)
    {
        //
    }
}
