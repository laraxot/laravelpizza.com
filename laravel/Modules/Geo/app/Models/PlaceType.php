<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static Builder<static>|PlaceType newModelQuery()
 * @method static Builder<static>|PlaceType newQuery()
 * @method static Builder<static>|PlaceType query()
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $deleter
 *
 * @method static \Modules\Geo\Database\Factories\PlaceTypeFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class PlaceType extends BaseModel
{
    use HasXotFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Definisci le relazioni e i metodi necessari per la classe PlaceType
}
