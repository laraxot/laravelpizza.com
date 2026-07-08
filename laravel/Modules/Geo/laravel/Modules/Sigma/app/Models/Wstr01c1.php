<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wstr01c1.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $wtannu
 * @property string|null $wtsens
 * @property string|null $wtindi
 * @property string|null $wtbadg
 * @property string|null $wtdata
 * @property string|null $wtteor
 * @property string|null $wtorat
 * @property string|null $wtmatr
 * @property string|null $wtcaus
 * @property string|null $wtflg1
 * @property string|null $wtflg2
 * @property string|null $wtcomp
 * @property string|null $wtcom2
 *
 * @method static Builder|Wstr01c1 newModelQuery()
 * @method static Builder|Wstr01c1 newQuery()
 * @method static Builder|Wstr01c1 query()
 * @method static Builder|Wstr01c1 whereEnteap($value)
 * @method static Builder|Wstr01c1 whereId($value)
 * @method static Builder|Wstr01c1 whereWtannu($value)
 * @method static Builder|Wstr01c1 whereWtbadg($value)
 * @method static Builder|Wstr01c1 whereWtcaus($value)
 * @method static Builder|Wstr01c1 whereWtcom2($value)
 * @method static Builder|Wstr01c1 whereWtcomp($value)
 * @method static Builder|Wstr01c1 whereWtdata($value)
 * @method static Builder|Wstr01c1 whereWtflg1($value)
 * @method static Builder|Wstr01c1 whereWtflg2($value)
 * @method static Builder|Wstr01c1 whereWtindi($value)
 * @method static Builder|Wstr01c1 whereWtmatr($value)
 * @method static Builder|Wstr01c1 whereWtorat($value)
 * @method static Builder|Wstr01c1 whereWtsens($value)
 * @method static Builder|Wstr01c1 whereWtteor($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wstr01c1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wstr01c1 extends BaseModel
{
    protected $table = 'wstr01c1';
}
