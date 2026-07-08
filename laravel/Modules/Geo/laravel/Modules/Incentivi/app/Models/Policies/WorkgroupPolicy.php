<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\Workgroup;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for Workgroup model.
 * Handles authorization for workgroup-related operations.
 */
class WorkgroupPolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any workgroups.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can view the workgroup.
     */
    public function view(UserContract $user, Workgroup $workgroup): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        if ($this->hasHRAccess($user)) {
            return true;
        }

        // Dipendente può vedere workgroup a cui appartiene
        return $workgroup->employees()->where('employee_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create workgroups.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can update the workgroup.
     */
    public function update(UserContract $user, Workgroup $workgroup): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can delete the workgroup.
     */
    public function delete(UserContract $user, Workgroup $workgroup): bool
    {
        if (! $this->isIncentiviAdmin($user)) {
            return false;
        }

        // Non può eliminare se ha progetti attivi (logica da implementare)
        return true;
    }

    /**
     * Determine whether the user can manage workgroup members.
     */
    public function manageMembers(UserContract $user, Workgroup $workgroup): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view workgroup projects.
     */
    public function viewProjects(UserContract $user, Workgroup $workgroup): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user)) {
            return true;
        }

        // Membri del gruppo possono vedere i progetti
        return $workgroup->employees()->where('employee_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can assign workgroup to project.
     */
    public function assignToProject(UserContract $user, Workgroup $workgroup): bool
    {
        return $this->isIncentiviAdmin($user);
    }
}
