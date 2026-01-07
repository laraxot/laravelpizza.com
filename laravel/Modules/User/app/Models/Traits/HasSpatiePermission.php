<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Models\ModelHasRole;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

trait HasSpatiePermission
{
    use HasPermissions;
    use HasRoles;
    /*
        public function roles(): BelongsToMany
        {
            return $this->belongsToManyX(Role::class)->using(ModelHasRole::class);
        }

        public function permissions(): BelongsToMany
        {
            return $this->belongsToManyX(Permission::class);
        }
        */
}
