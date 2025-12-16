<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Geo\Models\GeoNamesCap.
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static Builder<static>|GeoNamesCap newModelQuery()
 * @method static Builder<static>|GeoNamesCap newQuery()
 * @method static Builder<static>|GeoNamesCap query()
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $deleter
 *
 * @method static \Modules\Geo\Database\Factories\GeoNamesCapFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class GeoNamesCap extends BaseModel
{
    // use Searchable;

    /** @var string */
    protected $table = 'geonames_cap';

    // protected $connection = 'geo';
    /*
     * { function_description }
     *
     */
    /*
     * function __construct(){
     * $this->setConnection('user');
     * parent::__construct();
     * }//end construct
     */
}
