<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Database\Factories\CountyFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|County newModelQuery()
 * @method static Builder<static>|County newQuery()
 * @method static Builder<static>|County query()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static CountyFactory factory($count = null, $state = [])
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static \Modules\Geo\Database\Factories\CountyFactory factory($count = null, $state = [])
 * @method static Builder<static>|County newModelQuery()
 * @method static Builder<static>|County newQuery()
 * @method static Builder<static>|County query()
 *                                               >>>>>>> 65bf1208 (.)
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
