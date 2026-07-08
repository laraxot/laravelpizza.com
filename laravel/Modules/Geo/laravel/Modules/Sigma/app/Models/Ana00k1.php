<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana00k1.
 *
 * @property int $id
 * @property string|null $entec
 * @property string|null $matrc
 * @property string|null $codfic
 *
 * @method static Builder|Ana00k1 newModelQuery()
 * @method static Builder|Ana00k1 newQuery()
 * @method static Builder|Ana00k1 query()
 * @method static Builder|Ana00k1 whereCodfic($value)
 * @method static Builder|Ana00k1 whereEntec($value)
 * @method static Builder|Ana00k1 whereId($value)
 * @method static Builder|Ana00k1 whereMatrc($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana00k1 extends BaseModel
{
    protected $table = 'ana00k1';
}
