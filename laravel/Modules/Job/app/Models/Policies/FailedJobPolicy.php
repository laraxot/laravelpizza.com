<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\FailedJob;
use Modules\Xot\Contracts\UserContract;

/**
 * Deny-by-default: `failed_jobs` è osservabile, non creabile a mano.
 * Bypass: `JobBasePolicy::before` (super-admin / job::admin).
 */
class FailedJobPolicy extends JobBasePolicy
{
    public function viewAny(UserContract $_user): bool
    {
        return false;
    }

    public function view(UserContract $_user, FailedJob $_failedJob): bool
    {
        return false;
    }

    public function create(UserContract $_user): bool
    {
        return false;
    }

    public function update(UserContract $_user, FailedJob $_failedJob): bool
    {
        return false;
    }

    public function delete(UserContract $_user, FailedJob $_failedJob): bool
    {
        return false;
    }
}
