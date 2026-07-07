<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * Spatie Permission — standard rigido: {@see HasRoles::teams()} resta pubblico come da package.
 */
trait HasSpatiePermission
{
    use HasPermissions;
    use HasRoles;
}
