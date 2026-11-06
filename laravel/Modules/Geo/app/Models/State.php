<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Geo\Database\Factories\StateFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|State newModelQuery()
 * @method static Builder<static>|State newQuery()
 * @method static Builder<static>|State query()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static StateFactory factory($count = null, $state = [])
 *
 * @property string      $id
 * @property string      $state
 * @property string      $state_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|State whereCreatedAt($value)
 * @method static Builder<static>|State whereId($value)
 * @method static Builder<static>|State whereState($value)
 * @method static Builder<static>|State whereStateCode($value)
 * @method static Builder<static>|State whereUpdatedAt($value)
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
