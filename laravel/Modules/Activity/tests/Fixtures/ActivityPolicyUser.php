<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Modules\User\Models\User;
<<<<<<< .merge_file_alEvZ7
=======
use Spatie\Permission\Contracts\Permission;
>>>>>>> .merge_file_4FoNSx

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

<<<<<<< .merge_file_alEvZ7
=======
    /** @param string|int|Permission|\BackedEnum $permission */
>>>>>>> .merge_file_4FoNSx
    public function hasPermissionTo($permission, ?string $guardName = null): bool
    {
        return is_string($permission) && in_array($permission, $this->permissions, true);
    }
}
