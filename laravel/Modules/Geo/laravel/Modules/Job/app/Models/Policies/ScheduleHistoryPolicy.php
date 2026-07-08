<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\ScheduleHistory;
use Modules\Xot\Contracts\UserContract;

class ScheduleHistoryPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('schedule_history.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, ScheduleHistory $_schedule_history): bool
    {
        return $user->hasPermissionTo('schedule_history.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('schedule_history.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, ScheduleHistory $_schedule_history): bool
    {
        return $user->hasPermissionTo('schedule_history.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, ScheduleHistory $_schedule_history): bool
    {
        return $user->hasPermissionTo('schedule_history.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, ScheduleHistory $_schedule_history): bool
    {
        return $user->hasPermissionTo('schedule_history.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, ScheduleHistory $schedule_history): bool
    {
        return $user->hasPermissionTo('schedule_history.forceDelete');
    }
}
