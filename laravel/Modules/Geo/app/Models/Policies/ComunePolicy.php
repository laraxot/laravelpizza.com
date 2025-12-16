<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\Comune;
use Modules\Xot\Contracts\UserContract;

class ComunePolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('comune.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Comune $comune): bool
    {
        return $user->hasPermissionTo('comune.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('comune.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Comune $comune): bool
    {
        return $user->hasPermissionTo('comune.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Comune $comune): bool
    {
        return $user->hasPermissionTo('comune.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Comune $comune): bool
    {
        return $user->hasPermissionTo('comune.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Comune $comune): bool
    {
        return $user->hasPermissionTo('comune.forceDelete');
    }
}
