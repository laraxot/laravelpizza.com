<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Spatie\LaravelData\Data;

/**
 * Undocumented class.
 */
class PermissionModelsData extends Data
{
    public string $permission;

    // Modules\User\Models\Permission::class;
    public string $role; // Modules\User\Models\Role::class;
}
