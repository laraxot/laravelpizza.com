<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Fixtures;

use Modules\User\Contracts\HasShieldPermissions;
use Modules\User\Models\User;

/**
 * Resource stub per test ShieldUtilsAction senza classi anonime.
 */
final class HasShieldPermissionsFixture implements HasShieldPermissions
{
    public static function getModel(): string
    {
        return User::class;
    }

    /**
     * @return array<int, string>
     */
    public static function getPermissionPrefixes(): array
    {
        return ['custom-view', 'custom-update'];
    }
}
