<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create products')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update products.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->can('edit products')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete products.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->can('delete products')) {
            return true;
        }
    }
}
