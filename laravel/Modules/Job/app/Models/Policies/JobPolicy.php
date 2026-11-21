<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Job;
use Modules\Xot\Contracts\UserContract;

/**
 * Deny-by-default: la tabella `jobs` è scritta dalla coda, non da Form Filament.
 * Bypass: `JobBasePolicy::before` (super-admin / job::admin).
 */
class JobPolicy extends JobBasePolicy
{
    public function viewAny(UserContract $_user): bool
    {
        return false;
    }

    public function view(UserContract $_user, Job $_job): bool
    {
        return false;
    }

    public function create(UserContract $_user): bool
    {
        return false;
    }

    public function update(UserContract $_user, Job $_job): bool
    {
        return false;
    }

    public function delete(UserContract $_user, Job $_job): bool
    {
        return false;
    }
}
