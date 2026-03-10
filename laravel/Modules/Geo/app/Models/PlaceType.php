<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Database\Factories\PlaceTypeFactory;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|PlaceType newModelQuery()
 * @method static Builder<static>|PlaceType newQuery()
 * @method static Builder<static>|PlaceType query()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static PlaceTypeFactory factory($count = null, $state = [])
 *
 * @property string                          $id
 * @property string                          $name
 * @property string|null                     $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static Builder<static>|PlaceType whereCreatedAt($value)
 * @method static Builder<static>|PlaceType whereDescription($value)
 * @method static Builder<static>|PlaceType whereId($value)
 * @method static Builder<static>|PlaceType whereName($value)
 * @method static Builder<static>|PlaceType whereUpdatedAt($value)
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
