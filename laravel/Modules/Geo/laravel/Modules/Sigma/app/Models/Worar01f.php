<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Worar01f.
 *
 * @property int $id
 * @property int|null $enteap
 * @property string|null $orannu
 * @property string|null $orcodi
 * @property int|null $ordal
 * @property int|null $oral
 * @property string|null $wsc3b
 *
 * @method static Builder|Worar01f newModelQuery()
 * @method static Builder|Worar01f newQuery()
 * @method static Builder|Worar01f query()
 * @method static Builder|Worar01f whereEnteap($value)
 * @method static Builder|Worar01f whereId($value)
 * @method static Builder|Worar01f whereOral($value)
 * @method static Builder|Worar01f whereOrannu($value)
 * @method static Builder|Worar01f whereOrcodi($value)
 * @method static Builder|Worar01f whereOrdal($value)
 * @method static Builder|Worar01f whereWsc3b($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Worar01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Worar01f extends BaseModel
{
    protected $table = 'worar01f';
}
