<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Schedule;
use Modules\Xot\Contracts\UserContract;

class SchedulePolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('schedule.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Schedule $_schedule): bool
    {
        return $user->hasPermissionTo('schedule.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('schedule.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Schedule $_schedule): bool
    {
        return $user->hasPermissionTo('schedule.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Schedule $_schedule): bool
    {
        return $user->hasPermissionTo('schedule.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Schedule $_schedule): bool
    {
        return $user->hasPermissionTo('schedule.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Schedule $schedule): bool
    {
        return $user->hasPermissionTo('schedule.forceDelete');
    }
}
