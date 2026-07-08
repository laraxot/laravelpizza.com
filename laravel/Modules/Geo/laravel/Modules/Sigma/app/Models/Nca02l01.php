<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Nca02l01.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $paymon
 * @property string|null $payann
 * @property string|null $anno
 * @property string|null $scont
 * @property string|null $svocfi
 * @property string|null $impbil
 * @property string|null $tipret
 * @property string|null $codist
 * @property string|null $totc1
 * @property string|null $totc2
 * @property string|null $totc3
 * @property string|null $totc4
 * @property string|null $totc5
 * @property string|null $cla
 * @property string|null $sta
 * @property string|null $rep
 * @property string|null $ruo
 * @property string|null $pro
 * @property string|null $pos
 * @property string|null $liv
 *
 * @method static Builder|Nca02l01 newModelQuery()
 * @method static Builder|Nca02l01 newQuery()
 * @method static Builder|Nca02l01 query()
 * @method static Builder|Nca02l01 whereAnno($value)
 * @method static Builder|Nca02l01 whereCla($value)
 * @method static Builder|Nca02l01 whereCodist($value)
 * @method static Builder|Nca02l01 whereEnte($value)
 * @method static Builder|Nca02l01 whereId($value)
 * @method static Builder|Nca02l01 whereImpbil($value)
 * @method static Builder|Nca02l01 whereLiv($value)
 * @method static Builder|Nca02l01 whereMatr($value)
 * @method static Builder|Nca02l01 wherePayann($value)
 * @method static Builder|Nca02l01 wherePaymon($value)
 * @method static Builder|Nca02l01 wherePos($value)
 * @method static Builder|Nca02l01 wherePro($value)
 * @method static Builder|Nca02l01 whereRep($value)
 * @method static Builder|Nca02l01 whereRuo($value)
 * @method static Builder|Nca02l01 whereScont($value)
 * @method static Builder|Nca02l01 whereSta($value)
 * @method static Builder|Nca02l01 whereSvocfi($value)
 * @method static Builder|Nca02l01 whereTipret($value)
 * @method static Builder|Nca02l01 whereTotc1($value)
 * @method static Builder|Nca02l01 whereTotc2($value)
 * @method static Builder|Nca02l01 whereTotc3($value)
 * @method static Builder|Nca02l01 whereTotc4($value)
 * @method static Builder|Nca02l01 whereTotc5($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Nca02l01Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Nca02l01 extends BaseModel
{
    protected $table = 'nca02l01';
}
