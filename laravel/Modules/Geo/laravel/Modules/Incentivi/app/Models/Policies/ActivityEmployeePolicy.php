<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\ActivityEmployee;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for ActivityEmployee pivot model.
 * Handles authorization for activity-employee assignments.
 */
class ActivityEmployeePolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any activity-employee assignments.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can view the assignment.
     */
    public function view(UserContract $user, ActivityEmployee $activityEmployee): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user, $activityEmployee->activity->project)) {
            return true;
        }

        // Dipendente può vedere le proprie assegnazioni
        return $user->id === $activityEmployee->employee_id;
    }

    /**
     * Determine whether the user can create assignments.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can update the assignment.
     */
    public function update(UserContract $user, ActivityEmployee $activityEmployee): bool
    {
        // if (!($this->isIncentiviAdmin($user))) {
        //     return false;
        // }

        // return $this->isProjectEditable($activityEmployee->activity->project);

        return true;
    }

    /**
     * Determine whether the user can delete the assignment.
     */
    public function delete(UserContract $user, ActivityEmployee $activityEmployee): bool
    {
        if (! ($this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user, $activityEmployee->activity->project))) {
            return false;
        }

        return $this->isProjectEditable($activityEmployee->activity->project);
    }
}
