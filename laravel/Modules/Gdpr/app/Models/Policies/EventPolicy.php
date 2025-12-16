<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models\Policies;

use Modules\Gdpr\Models\Event;
use Modules\Xot\Contracts\UserContract;

class EventPolicy extends GdprBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('event.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Event $_event): bool
    {
        return $user->hasPermissionTo('event.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('event.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Event $_event): bool
    {
        return $user->hasPermissionTo('event.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Event $_event): bool
    {
        return $user->hasPermissionTo('event.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Event $_event): bool
    {
        return $user->hasPermissionTo('event.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Event $event): bool
    {
        return $user->hasPermissionTo('event.forceDelete');
    }
}
