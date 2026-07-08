<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\Settlement;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for Settlement model.
 * Handles authorization for settlement-related operations.
 */
class SettlementPolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any settlements.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->hasFinanceAccess($user) || $this->isWorkgroupManager($user);
    }

    /**
     * Determine whether the user can view the settlement.
     */
    public function view(UserContract $user, Settlement $settlement): bool
    {
        if ($this->hasFinanceAccess($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user, $settlement->project)) {
            return true;
        }

        // Dipendente può vedere liquidazioni dei propri progetti
        return $this->isAssignedToProject($user, $settlement->project);
    }

    /**
     * Determine whether the user can create settlements.
     */
    public function create(UserContract $user): bool
    {
        return $this->hasFinanceAccess($user);
    }

    /**
     * Determine whether the user can update the settlement.
     */
    public function update(UserContract $user, Settlement $settlement): bool
    {
        if (! $this->hasFinanceAccess($user)) {
            return false;
        }

        // Liquidazioni approvate non possono essere modificate
        return ! ($settlement->approved ?? false);
    }

    /**
     * Determine whether the user can delete the settlement.
     */
    public function delete(UserContract $user, Settlement $settlement): bool
    {
        if (! $this->hasFinanceAccess($user)) {
            return false;
        }

        // Solo liquidazioni non approvate possono essere eliminate
        return ! ($settlement->approved ?? false);
    }

    /**
     * Determine whether the user can approve the settlement.
     */
    public function approve(UserContract $user, Settlement $settlement): bool
    {
        return $user->hasRole(['super-admin', 'finance-manager']);
    }

    /**
     * Determine whether the user can process the settlement.
     */
    public function process(UserContract $user, Settlement $settlement): bool
    {
        if (! $this->hasFinanceAccess($user)) {
            return false;
        }

        // Solo liquidazioni approvate possono essere processate
        $approved = isset($settlement->approved) ? (bool) $settlement->approved : false;

        return $approved;
    }

    /**
     * Determine whether the user can reverse the settlement.
     */
    public function reverse(UserContract $user, Settlement $settlement): bool
    {
        return $user->hasRole('super-admin');
    }
}
