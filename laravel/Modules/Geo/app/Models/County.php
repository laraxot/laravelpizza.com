<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static Builder<static>|County newModelQuery()
 * @method static Builder<static>|County newQuery()
 * @method static Builder<static>|County query()
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $deleter
 *
 * @method static \Modules\Geo\Database\Factories\CountyFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class County extends BaseModel
{
    protected $fillable = [
        'state_id',
        'county',
        'state_index',
    ];
}
