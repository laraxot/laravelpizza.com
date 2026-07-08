<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wstr01l3.
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
 * @property string|null $wxorat
 * @property string|null $wyorat
 * @property string|null $t1codi
 * @property string|null $orcodi
 * @property string|null $wtmatr
 * @property string|null $wtcaus
 * @property string|null $wtflg1
 * @property string|null $wtflg2
 * @property string|null $wtcomp
 * @property string|null $wtcom1
 * @property string|null $wtcom2
 *
 * @method static Builder|Wstr01l3 newModelQuery()
 * @method static Builder|Wstr01l3 newQuery()
 * @method static Builder|Wstr01l3 query()
 * @method static Builder|Wstr01l3 whereEnteap($value)
 * @method static Builder|Wstr01l3 whereId($value)
 * @method static Builder|Wstr01l3 whereOrcodi($value)
 * @method static Builder|Wstr01l3 whereT1codi($value)
 * @method static Builder|Wstr01l3 whereWtannu($value)
 * @method static Builder|Wstr01l3 whereWtbadg($value)
 * @method static Builder|Wstr01l3 whereWtcaus($value)
 * @method static Builder|Wstr01l3 whereWtcom1($value)
 * @method static Builder|Wstr01l3 whereWtcom2($value)
 * @method static Builder|Wstr01l3 whereWtcomp($value)
 * @method static Builder|Wstr01l3 whereWtdata($value)
 * @method static Builder|Wstr01l3 whereWtflg1($value)
 * @method static Builder|Wstr01l3 whereWtflg2($value)
 * @method static Builder|Wstr01l3 whereWtindi($value)
 * @method static Builder|Wstr01l3 whereWtmatr($value)
 * @method static Builder|Wstr01l3 whereWtorat($value)
 * @method static Builder|Wstr01l3 whereWtsens($value)
 * @method static Builder|Wstr01l3 whereWtteor($value)
 * @method static Builder|Wstr01l3 whereWxorat($value)
 * @method static Builder|Wstr01l3 whereWyorat($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wstr01l3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wstr01l3 extends BaseModel
{
    protected $table = 'wstr01l3';
}
