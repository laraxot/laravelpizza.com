<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\CapitalPercentage;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for CapitalPercentage model.
 * Handles authorization for capital percentage configuration.
 */
class CapitalPercentagePolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any capital percentages.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can view the capital percentage.
     */
    public function view(UserContract $user, CapitalPercentage $capitalPercentage): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can create capital percentages.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can update the capital percentage.
     */
    public function update(UserContract $user, CapitalPercentage $capitalPercentage): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can delete the capital percentage.
     */
    public function delete(UserContract $user, CapitalPercentage $capitalPercentage): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }
}
