<?php

namespace App\Policies;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the User can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param  \App\Models\User  $user
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->hasRole(config('permission.access.list-category'));
    }

    /**
     * Determine whether the User can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole(config('permission.access.add-category'));
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param  \App\Models\User  $user
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->hasRole(config('permission.access.edit-category'));
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param  \App\Models\User  $user
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->hasRole(config('permission.access.delete-category'));
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param  \App\Models\User  $user
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
