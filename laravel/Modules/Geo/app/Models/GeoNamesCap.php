<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Database\Factories\GeoNamesCapFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Geo\Models\GeoNamesCap.
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|GeoNamesCap newModelQuery()
 * @method static Builder<static>|GeoNamesCap newQuery()
 * @method static Builder<static>|GeoNamesCap query()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static GeoNamesCapFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class GeoNamesCap extends BaseModel
{
    // use Searchable;

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
