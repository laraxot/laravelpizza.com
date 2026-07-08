<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\Activity;
use Modules\Xot\Contracts\UserContract;
use Override;

class ActivityPolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any activities.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the activity.
     */
    public function view(UserContract $user, Activity $activity): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        // Dipendente può vedere attività a cui è assegnato
        if ($activity->employees()->where('employee_id', $user->id)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create activities.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user);
    }

    /**
     * Determine whether the user can update the activity.
     */
    public function update(UserContract $user, Activity $activity): bool
    {
        // if (!($this->isIncentiviAdmin($user))) {
        //     return false;
        // }

        //  if ($activity->employees()->where('employee_id', $user->id)->exists()) {
        //     return true;
        // }

        // Attività di progetti conclusi non modificabili
        // if ($activity->project && in_array($activity->project->stato->value, ['concluso', 'cancellato'])) {
        //     return false;
        // }

        return true;
    }

    /**
     * Determine whether the user can delete the activity.
     */
    public function delete(UserContract $user, Activity $activity): bool
    {
        if (! ($this->isIncentiviAdmin($user) || $this->hasHRAccess($user))) {
            return false;
        }

        // // Le attività con dipendenti assegnati non possono essere eliminate
        // if ($activity->employees()->count() > 0) {
        //     return false;
        // }

        return true;
    }

    /**
     * Determine whether the user can assign employees to activity.
     */
    public function assignEmployees(UserContract $user, Activity $activity): bool
    {
        if (! ($this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user, $activity))) {
            return false;
        }

        // Non si possono assegnare dipendenti ad attività di progetti conclusi
        if ($activity->project && in_array($activity->project->stato->value, ['concluso', 'cancellato'])) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can calculate activity amount.
     */
    public function calculateAmount(UserContract $user, Activity $activity): bool
    {
        return $this->isIncentiviAdmin($user);
    }

    /**
     * Determine whether the user can validate activity percentages.
     */
    public function validatePercentages(UserContract $user, Activity $activity): bool
    {
        return $this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user, $activity);
    }

    /**
     * Determine whether the user can duplicate the activity.
     */
    public function replicate(UserContract $user, Activity $activity): bool
    {
        return $this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user, $activity);
    }
}
