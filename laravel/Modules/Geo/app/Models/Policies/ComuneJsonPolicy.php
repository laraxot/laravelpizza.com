<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\ComuneJson;
use Modules\Xot\Contracts\UserContract;

class ComuneJsonPolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('comune_json.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, ComuneJson $comune_json): bool
    {
        return $user->hasPermissionTo('comune_json.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('comune_json.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, ComuneJson $comune_json): bool
    {
        return $user->hasPermissionTo('comune_json.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, ComuneJson $comune_json): bool
    {
        return $user->hasPermissionTo('comune_json.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, ComuneJson $comune_json): bool
    {
        return $user->hasPermissionTo('comune_json.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, ComuneJson $comune_json): bool
    {
        return $user->hasPermissionTo('comune_json.forceDelete');
    }
}
