<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Modules\User\Models\User;
use Spatie\Permission\Contracts\Permission;

/**
 * Fake User per test ActivityPolicy.
 *
 * Consente di simulare permessi specifici senza dipendere da database.
 */
final class ActivityPolicyUser extends User
{
    /** @param list<string> $permissions */
    public function __construct(private readonly array $permissions)
    {
        parent::__construct();
    }

    /** @param string|int|Permission|\BackedEnum $permission */
    public function hasPermissionTo($permission, ?string $guardName = null): bool
    {
        return is_string($permission) && in_array($permission, $this->permissions, true);
    }
}
