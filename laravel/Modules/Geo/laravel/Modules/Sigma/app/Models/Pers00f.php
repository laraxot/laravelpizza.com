<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Pers00f.
 *
 * @property int $id
 * @property string|null $ENTEAP
 * @property string|null $PEPGM
 * @property string|null $PERIGA
 * @property string|null $PEPROV
 * @property string|null $PEPERS
 *
 * @method static Builder|Pers00f newModelQuery()
 * @method static Builder|Pers00f newQuery()
 * @method static Builder|Pers00f query()
 * @method static Builder|Pers00f whereENTEAP($value)
 * @method static Builder|Pers00f whereId($value)
 * @method static Builder|Pers00f wherePEPERS($value)
 * @method static Builder|Pers00f wherePEPGM($value)
 * @method static Builder|Pers00f wherePEPROV($value)
 * @method static Builder|Pers00f wherePERIGA($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Pers00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Pers00f extends BaseModel
{
    protected $table = 'pers00f';
}
