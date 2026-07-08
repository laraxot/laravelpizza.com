<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cenc1f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $cdccod
 * @property string|null $cdcdal
 * @property string|null $cdcal
 * @property string|null $cdcdec
 * @property string|null $cdcdel
 * @property string|null $cdcas1
 * @property string|null $cdcas2
 * @property string|null $cdcas3
 * @property string|null $cdcas4
 * @property string|null $cdc001
 * @property string|null $cdc002
 * @property string|null $cdc003
 *
 * @method static Builder|Cenc1f newModelQuery()
 * @method static Builder|Cenc1f newQuery()
 * @method static Builder|Cenc1f query()
 * @method static Builder|Cenc1f whereCdc001($value)
 * @method static Builder|Cenc1f whereCdc002($value)
 * @method static Builder|Cenc1f whereCdc003($value)
 * @method static Builder|Cenc1f whereCdcal($value)
 * @method static Builder|Cenc1f whereCdcas1($value)
 * @method static Builder|Cenc1f whereCdcas2($value)
 * @method static Builder|Cenc1f whereCdcas3($value)
 * @method static Builder|Cenc1f whereCdcas4($value)
 * @method static Builder|Cenc1f whereCdccod($value)
 * @method static Builder|Cenc1f whereCdcdal($value)
 * @method static Builder|Cenc1f whereCdcdec($value)
 * @method static Builder|Cenc1f whereCdcdel($value)
 * @method static Builder|Cenc1f whereEnte($value)
 * @method static Builder|Cenc1f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cenc1fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cenc1f extends BaseModel
{
    protected $table = 'cenc1f';
}
