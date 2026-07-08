<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\Phase;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for Phase model.
 * Handles authorization for phase-related operations.
 */
class PhasePolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any phases.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user);
    }

    /**
     * Determine whether the user can view the phase.
     */
    public function view(UserContract $user, Phase $phase): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user, $phase->project)) {
            return true;
        }

        return $this->isAssignedToProject($user, $phase->project);
    }

    /**
     * Determine whether the user can create phases.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user);
    }

    /**
     * Determine whether the user can update the phase.
     */
    public function update(UserContract $user, Phase $phase): bool
    {
        if (! ($this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user, $phase->project))) {
            return false;
        }

        // Fasi con liquidazioni non possono essere modificate
        return ! ($phase->settlement ?? false);
    }

    /**
     * Determine whether the user can delete the phase.
     */
    public function delete(UserContract $user, Phase $phase): bool
    {
        if (! $this->isIncentiviAdmin($user)) {
            return false;
        }

        // Non può eliminare se ha liquidazioni
        return ! ($phase->settlement ?? false);
    }
}
