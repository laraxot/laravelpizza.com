<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Spatie\LaravelData\Data;

/**
 * Undocumented class.
 */
class PermissionTableNamesData extends Data
{
    public string $roles;

    //  'roles',
    public string $permissions;

    // 'permissions'
    public string $model_has_permissions;

    // ' => 'model_has_permissions',
    public string $model_has_roles;

    // ' => 'model_has_roles',
    public string $role_has_permissions; // ' => 'role_has_permissions',
}
