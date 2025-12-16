<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static Builder<static>|State newModelQuery()
 * @method static Builder<static>|State newQuery()
 * @method static Builder<static>|State query()
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $deleter
 *
 * @method static \Modules\Geo\Database\Factories\StateFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class State extends BaseModel
{
    protected $fillable = [
        'state',
        'state_code',
    ];
}
