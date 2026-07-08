<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\DefaultActivity;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Policy for DefaultActivity model.
 * Handles authorization for default activity templates.
 */
class DefaultActivityPolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any default activities.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can view the default activity.
     */
    public function view(UserContract $user, DefaultActivity $defaultActivity): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can create default activities.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can update the default activity.
     */
    public function update(UserContract $user, DefaultActivity $defaultActivity): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can delete the default activity.
     */
    public function delete(UserContract $user, DefaultActivity $defaultActivity): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }
}
