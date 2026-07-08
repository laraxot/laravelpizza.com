<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repa1l3.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $stabi
 * @property string|null $repar
 * @property string|null $tipcod
 * @property string|null $clafun
 * @property string|null $claind
 * @property string|null $cc1
 * @property string|null $cc2
 * @property string|null $cc3
 * @property string|null $cs1
 * @property string|null $cs2
 * @property string|null $cs3
 * @property string|null $sr1
 * @property string|null $sr2
 * @property string|null $po1
 * @property string|null $po2
 * @property string|null $re1
 * @property string|null $re2
 * @property string|null $da1
 * @property string|null $da2
 * @property string|null $descom
 * @property string|null $pronta
 * @property string|null $strcod
 * @property string|null $sstcod
 * @property string|null $artcod
 * @property string|null $arttip
 * @property string|null $aggstr
 * @property string|null $aggser
 * @property string|null $aggtip
 *
 * @method static Builder|Repa1l3 newModelQuery()
 * @method static Builder|Repa1l3 newQuery()
 * @method static Builder|Repa1l3 query()
 * @method static Builder|Repa1l3 whereAggser($value)
 * @method static Builder|Repa1l3 whereAggstr($value)
 * @method static Builder|Repa1l3 whereAggtip($value)
 * @method static Builder|Repa1l3 whereArtcod($value)
 * @method static Builder|Repa1l3 whereArttip($value)
 * @method static Builder|Repa1l3 whereCc1($value)
 * @method static Builder|Repa1l3 whereCc2($value)
 * @method static Builder|Repa1l3 whereCc3($value)
 * @method static Builder|Repa1l3 whereClafun($value)
 * @method static Builder|Repa1l3 whereClaind($value)
 * @method static Builder|Repa1l3 whereCs1($value)
 * @method static Builder|Repa1l3 whereCs2($value)
 * @method static Builder|Repa1l3 whereCs3($value)
 * @method static Builder|Repa1l3 whereDa1($value)
 * @method static Builder|Repa1l3 whereDa2($value)
 * @method static Builder|Repa1l3 whereDescom($value)
 * @method static Builder|Repa1l3 whereEnte($value)
 * @method static Builder|Repa1l3 whereId($value)
 * @method static Builder|Repa1l3 wherePo1($value)
 * @method static Builder|Repa1l3 wherePo2($value)
 * @method static Builder|Repa1l3 wherePronta($value)
 * @method static Builder|Repa1l3 whereRe1($value)
 * @method static Builder|Repa1l3 whereRe2($value)
 * @method static Builder|Repa1l3 whereRepar($value)
 * @method static Builder|Repa1l3 whereSr1($value)
 * @method static Builder|Repa1l3 whereSr2($value)
 * @method static Builder|Repa1l3 whereSstcod($value)
 * @method static Builder|Repa1l3 whereStabi($value)
 * @method static Builder|Repa1l3 whereStrcod($value)
 * @method static Builder|Repa1l3 whereTipcod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repa1l3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repa1l3 extends BaseModel
{
    protected $table = 'repa1l3';
}
