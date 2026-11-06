<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Fixtures;

use Illuminate\Support\Collection;
use Modules\User\Models\BaseUser;

/**
 * BaseUser stub con flag per canAccessPanel senza classi anonime.
 */
final class AdminPanelAccessUserFixture extends BaseUser
{
    public bool $superAdmin = false;

    public bool $hasAdminRole = false;

    public function isSuperAdmin(): bool
    {
        return $this->superAdmin;
    }

    /**
     * @param  array<int, string>|Collection<int, string>  $roles
     */
    public function hasRole($roles, ?string $guard = null): bool
    {
        return $this->hasAdminRole;
    }
}
