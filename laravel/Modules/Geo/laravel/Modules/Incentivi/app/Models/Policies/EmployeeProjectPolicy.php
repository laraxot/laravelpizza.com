<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\EmployeeProject;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for EmployeeProject pivot model.
 * Handles authorization for employee-project assignments.
 */
class EmployeeProjectPolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any assignments.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        // return $this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user);
        return true;
    }

    /**
     * Determine whether the user can view the assignment.
     */
    public function view(UserContract $user, EmployeeProject $assignment): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user)) {
            return true;
        }

        // Dipendente può vedere le proprie assegnazioni (logica da implementare)
        return true;
    }

    /**
     * Determine whether the user can create assignments.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user);
    }

    /**
     * Determine whether the user can update the assignment.
     */
    public function update(UserContract $user, EmployeeProject $assignment): bool
    {
        // if (!($this->isIncentiviAdmin($user))) {
        //     return false;
        // }

        // return $this->isProjectEditable($assignment->project);

        return true;
    }

    /**
     * Determine whether the user can delete the assignment.
     */
    public function delete(UserContract $user, EmployeeProject $assignment): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        } else {
            return false;
        }
    }
}
