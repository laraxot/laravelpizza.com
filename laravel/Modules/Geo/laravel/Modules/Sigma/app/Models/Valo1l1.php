<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Valo1l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $cont
 * @property string|null $va1rap
 * @property string|null $va1ora
 * @property string|null $va12kd
 * @property string|null $va12ka
 * @property string|null $va1o
 * @property string|null $va1g
 * @property string|null $va1s
 * @property string|null $va1m
 * @property string|null $va1ann
 * @property string|null $va1001
 * @property string|null $va1002
 * @property string|null $va1003
 * @property string|null $va1004
 * @property string|null $va1005
 *
 * @method static Builder|Valo1l1 newModelQuery()
 * @method static Builder|Valo1l1 newQuery()
 * @method static Builder|Valo1l1 query()
 * @method static Builder|Valo1l1 whereCont($value)
 * @method static Builder|Valo1l1 whereEnte($value)
 * @method static Builder|Valo1l1 whereId($value)
 * @method static Builder|Valo1l1 whereVa1001($value)
 * @method static Builder|Valo1l1 whereVa1002($value)
 * @method static Builder|Valo1l1 whereVa1003($value)
 * @method static Builder|Valo1l1 whereVa1004($value)
 * @method static Builder|Valo1l1 whereVa1005($value)
 * @method static Builder|Valo1l1 whereVa12ka($value)
 * @method static Builder|Valo1l1 whereVa12kd($value)
 * @method static Builder|Valo1l1 whereVa1ann($value)
 * @method static Builder|Valo1l1 whereVa1g($value)
 * @method static Builder|Valo1l1 whereVa1m($value)
 * @method static Builder|Valo1l1 whereVa1o($value)
 * @method static Builder|Valo1l1 whereVa1ora($value)
 * @method static Builder|Valo1l1 whereVa1rap($value)
 * @method static Builder|Valo1l1 whereVa1s($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Valo1l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Valo1l1 extends BaseModel
{
    protected $table = 'valo1l1';
}
