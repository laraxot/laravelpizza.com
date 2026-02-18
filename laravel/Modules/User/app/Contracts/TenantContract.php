<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;

/**
 * @property Collection<int, Model&UserContract> $members
 * @property int|null                            $members_count
 * @property ProfileContract|null                $creator
 * @property ProfileContract|null                $updater
 *
 * @phpstan-require-extends Model
 */
interface TenantContract
{
    // belongstomany or hasmany ?
    // public function users(): HasMany;
}
