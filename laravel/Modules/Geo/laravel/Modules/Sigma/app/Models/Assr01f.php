<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Assr01f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $strut
 * @property string|null $tabe
 * @property string|null $codic
 * @property string|null $descod
 * @property string|null $col01
 * @property string|null $col02
 * @property string|null $col03
 * @property string|null $col04
 * @property string|null $col05
 * @property string|null $col06
 * @property string|null $col07
 * @property string|null $col08
 * @property string|null $col09
 * @property string|null $col10
 * @property string|null $col11
 * @property string|null $col12
 * @property string|null $col13
 * @property string|null $col14
 * @property string|null $col15
 * @property string|null $col16
 * @property string|null $col17
 * @property string|null $col18
 * @property string|null $col19
 * @property string|null $col20
 *
 * @method static Builder|Assr01f newModelQuery()
 * @method static Builder|Assr01f newQuery()
 * @method static Builder|Assr01f query()
 * @method static Builder|Assr01f whereCodic($value)
 * @method static Builder|Assr01f whereCol01($value)
 * @method static Builder|Assr01f whereCol02($value)
 * @method static Builder|Assr01f whereCol03($value)
 * @method static Builder|Assr01f whereCol04($value)
 * @method static Builder|Assr01f whereCol05($value)
 * @method static Builder|Assr01f whereCol06($value)
 * @method static Builder|Assr01f whereCol07($value)
 * @method static Builder|Assr01f whereCol08($value)
 * @method static Builder|Assr01f whereCol09($value)
 * @method static Builder|Assr01f whereCol10($value)
 * @method static Builder|Assr01f whereCol11($value)
 * @method static Builder|Assr01f whereCol12($value)
 * @method static Builder|Assr01f whereCol13($value)
 * @method static Builder|Assr01f whereCol14($value)
 * @method static Builder|Assr01f whereCol15($value)
 * @method static Builder|Assr01f whereCol16($value)
 * @method static Builder|Assr01f whereCol17($value)
 * @method static Builder|Assr01f whereCol18($value)
 * @method static Builder|Assr01f whereCol19($value)
 * @method static Builder|Assr01f whereCol20($value)
 * @method static Builder|Assr01f whereDescod($value)
 * @method static Builder|Assr01f whereEnte($value)
 * @method static Builder|Assr01f whereId($value)
 * @method static Builder|Assr01f whereStrut($value)
 * @method static Builder|Assr01f whereTabe($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Assr01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Assr01f extends BaseModel
{
    protected $table = 'assr01f';
}
