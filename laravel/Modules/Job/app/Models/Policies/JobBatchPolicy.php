<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\JobBatch;
use Modules\Xot\Contracts\UserContract;

/**
 * Deny-by-default: i batch nascono dal Bus, non da create UI.
 * Bypass: `JobBasePolicy::before` (super-admin / job::admin).
 */
class JobBatchPolicy extends JobBasePolicy
{
    public function viewAny(UserContract $_user): bool
    {
        return false;
    }

    public function view(UserContract $_user, JobBatch $_batch): bool
    {
        return false;
    }

    public function create(UserContract $_user): bool
    {
        return false;
    }

    public function update(UserContract $_user, JobBatch $_batch): bool
    {
        return false;
    }

    public function delete(UserContract $_user, JobBatch $_batch): bool
    {
        return false;
    }
}
