<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\EmployeeWorkgroup;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for EmployeeWorkgroup pivot model.
 * Handles authorization for employee-workgroup memberships.
 */
class EmployeeWorkgroupPolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any memberships.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can view the membership.
     */
    public function view(UserContract $user, EmployeeWorkgroup $membership): bool
    {
        if ($this->hasHRAccess($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user)) {
            return true;
        }

        // Dipendente può vedere le proprie appartenenze
        return $user->id === $membership->employee_id;
    }

    /**
     * Determine whether the user can create memberships.
     */
    public function create(UserContract $user): bool
    {
        return $this->hasHRAccess($user) || $this->isWorkgroupManager($user);
    }

    /**
     * Determine whether the user can update the membership.
     */
    public function update(UserContract $user, EmployeeWorkgroup $membership): bool
    {
        if ($this->hasHRAccess($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the membership.
     */
    public function delete(UserContract $user, EmployeeWorkgroup $membership): bool
    {
        if ($this->hasHRAccess($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user)) {
            return true;
        }

        return false;
    }
}
