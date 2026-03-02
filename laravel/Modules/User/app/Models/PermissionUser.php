<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|PermissionUser newModelQuery()
 * @method static Builder<static>|PermissionUser newQuery()
 * @method static Builder<static>|PermissionUser query()
 * @mixin IdeHelperPermissionUser
 * @property ProfileContract|null $deleter
<<<<<<< HEAD
 *
 * @method static \Modules\User\Database\Factories\PermissionUserFactory factory($count = null, $state = [])
 *
||||||| parent of da38c10 (.)
 *
=======
 * @method static \Modules\User\Database\Factories\PermissionUserFactory factory($count = null, $state = [])
>>>>>>> da38c10 (.)
 * @mixin \Eloquent
 */
class PermissionUser extends ModelHasPermission
{
}
