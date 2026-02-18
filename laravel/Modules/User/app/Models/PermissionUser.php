<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|PermissionUser newModelQuery()
 * @method static Builder<static>|PermissionUser newQuery()
 * @method static Builder<static>|PermissionUser query()
 *
 * @mixin IdeHelperPermissionUser
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class PermissionUser extends ModelHasPermission {}
