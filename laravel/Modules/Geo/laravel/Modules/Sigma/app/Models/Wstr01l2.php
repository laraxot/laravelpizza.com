<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wstr01l2.
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
 * @method static Builder|Wstr01l2 newModelQuery()
 * @method static Builder|Wstr01l2 newQuery()
 * @method static Builder|Wstr01l2 query()
 * @method static Builder|Wstr01l2 whereEnteap($value)
 * @method static Builder|Wstr01l2 whereId($value)
 * @method static Builder|Wstr01l2 whereOrcodi($value)
 * @method static Builder|Wstr01l2 whereT1codi($value)
 * @method static Builder|Wstr01l2 whereWtannu($value)
 * @method static Builder|Wstr01l2 whereWtbadg($value)
 * @method static Builder|Wstr01l2 whereWtcaus($value)
 * @method static Builder|Wstr01l2 whereWtcom1($value)
 * @method static Builder|Wstr01l2 whereWtcom2($value)
 * @method static Builder|Wstr01l2 whereWtcomp($value)
 * @method static Builder|Wstr01l2 whereWtdata($value)
 * @method static Builder|Wstr01l2 whereWtflg1($value)
 * @method static Builder|Wstr01l2 whereWtflg2($value)
 * @method static Builder|Wstr01l2 whereWtindi($value)
 * @method static Builder|Wstr01l2 whereWtmatr($value)
 * @method static Builder|Wstr01l2 whereWtorat($value)
 * @method static Builder|Wstr01l2 whereWtsens($value)
 * @method static Builder|Wstr01l2 whereWtteor($value)
 * @method static Builder|Wstr01l2 whereWxorat($value)
 * @method static Builder|Wstr01l2 whereWyorat($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wstr01l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wstr01l2 extends BaseModel
{
    protected $table = 'wstr01l2';
}
