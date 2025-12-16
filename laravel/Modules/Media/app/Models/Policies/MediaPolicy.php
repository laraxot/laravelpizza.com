<?php

declare(strict_types=1);

namespace Modules\Media\Models\Policies;

use Modules\Media\Models\Media;
use Modules\Xot\Contracts\UserContract;

class MediaPolicy extends MediaBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('media.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Media $_media): bool
    {
        return $user->hasPermissionTo('media.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('media.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Media $_media): bool
    {
        return $user->hasPermissionTo('media.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Media $_media): bool
    {
        return $user->hasPermissionTo('media.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Media $_media): bool
    {
        return $user->hasPermissionTo('media.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Media $media): bool
    {
        return $user->hasPermissionTo('media.forceDelete');
    }
}
