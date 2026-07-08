<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ced50f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $repst2
 * @property string|null $repre2
 * @property string|null $cont
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $comme1
 * @property string|null $comme2
 * @property string|null $comme3
 * @property string|null $comme4
 * @property string|null $comme5
 * @property string|null $comme6
 * @property string|null $ordced
 * @property string|null $orduff
 * @property string|null $ordnas
 *
 * @method static Builder|Ced50f newModelQuery()
 * @method static Builder|Ced50f newQuery()
 * @method static Builder|Ced50f query()
 * @method static Builder|Ced50f whereComme1($value)
 * @method static Builder|Ced50f whereComme2($value)
 * @method static Builder|Ced50f whereComme3($value)
 * @method static Builder|Ced50f whereComme4($value)
 * @method static Builder|Ced50f whereComme5($value)
 * @method static Builder|Ced50f whereComme6($value)
 * @method static Builder|Ced50f whereCont($value)
 * @method static Builder|Ced50f whereEnte($value)
 * @method static Builder|Ced50f whereId($value)
 * @method static Builder|Ced50f whereOrdced($value)
 * @method static Builder|Ced50f whereOrdnas($value)
 * @method static Builder|Ced50f whereOrduff($value)
 * @method static Builder|Ced50f wherePosfun($value)
 * @method static Builder|Ced50f wherePropro($value)
 * @method static Builder|Ced50f whereRepre2($value)
 * @method static Builder|Ced50f whereRepst2($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ced50fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ced50f extends BaseModel
{
    protected $table = 'ced50f';
}
