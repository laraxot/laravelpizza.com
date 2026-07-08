<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\StabiDirigente;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for StabiDirigente model.
 * Handles authorization for settlement-related operations.
 */
class StabiDirigentePolicy extends IncentiviBasePolicy
{
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->hasFinanceAccess($user) || $this->isWorkgroupManager($user);
    }

    public function view(UserContract $user, StabiDirigente $stabiDirigente): bool
    {
        if ($this->hasFinanceAccess($user)) {
            return true;
        }

        $project = $stabiDirigente->project ?? null; // @phpstan-ignore-line
        if ($project !== null && $project instanceof \Illuminate\Database\Eloquent\Model && $this->isWorkgroupManager($user, $project)) {
            return true;
        }

        $project = $stabiDirigente->project ?? null; // @phpstan-ignore-line

        return $project !== null && $project instanceof \Illuminate\Database\Eloquent\Model && $this->isAssignedToProject($user, $project);
    }

    public function create(UserContract $user): bool
    {
        return $this->hasFinanceAccess($user);
    }

    public function update(UserContract $user, StabiDirigente $stabiDirigente): bool
    {
        if (! $this->hasFinanceAccess($user)) {
            return false;
        }

        return ! ($stabiDirigente->approved ?? false);
    }

    public function delete(UserContract $user, StabiDirigente $stabiDirigente): bool
    {
        if (! $this->hasFinanceAccess($user)) {
            return false;
        }

        return ! ($stabiDirigente->approved ?? false);
    }
}
