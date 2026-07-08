<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Voc00f.
 *
 * @property int $id
 * @property int|null $cont
 * @property int|null $vocret
 * @property int|null $tipret
 * @property string|null $desret
 * @property int|null $progre
 * @property int|null $tipcal
 * @property int|null $codcal
 * @property int|null $codasc
 * @property int|null $impbil
 *
 * @method static Builder|Voc00f newModelQuery()
 * @method static Builder|Voc00f newQuery()
 * @method static Builder|Voc00f query()
 * @method static Builder|Voc00f whereCodasc($value)
 * @method static Builder|Voc00f whereCodcal($value)
 * @method static Builder|Voc00f whereCont($value)
 * @method static Builder|Voc00f whereDesret($value)
 * @method static Builder|Voc00f whereId($value)
 * @method static Builder|Voc00f whereImpbil($value)
 * @method static Builder|Voc00f whereProgre($value)
 * @method static Builder|Voc00f whereTipcal($value)
 * @method static Builder|Voc00f whereTipret($value)
 * @method static Builder|Voc00f whereVocret($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Voc00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Voc00f extends BaseModel
{
    protected $table = 'voc00f';
}
