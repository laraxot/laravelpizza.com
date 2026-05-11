<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Geo\Database\Factories\CountyFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Suddivisione tipo “county” (contesto USA / geonames), non il comune italiano.
 *
 * @property string               $id
 * @property string               $county
 * @property string|null          $county_code
 * @property int|null             $state_id
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 *
 * @method static CountyFactory          factory($count = null, $state = [])
 * @method static Builder<static>|County newModelQuery()
 * @method static Builder<static>|County newQuery()
 * @method static Builder<static>|County query()
 * @method static Builder<static>|County whereCounty($value)
 * @method static Builder<static>|County whereCountyCode($value)
 * @method static Builder<static>|County whereCreatedAt($value)
 * @method static Builder<static>|County whereId($value)
 * @method static Builder<static>|County whereStateId($value)
 * @method static Builder<static>|County whereUpdatedAt($value)
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
