<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repa1l2.
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
 * @method static Builder|Repa1l2 newModelQuery()
 * @method static Builder|Repa1l2 newQuery()
 * @method static Builder|Repa1l2 query()
 * @method static Builder|Repa1l2 whereAggser($value)
 * @method static Builder|Repa1l2 whereAggstr($value)
 * @method static Builder|Repa1l2 whereAggtip($value)
 * @method static Builder|Repa1l2 whereArtcod($value)
 * @method static Builder|Repa1l2 whereArttip($value)
 * @method static Builder|Repa1l2 whereCc1($value)
 * @method static Builder|Repa1l2 whereCc2($value)
 * @method static Builder|Repa1l2 whereCc3($value)
 * @method static Builder|Repa1l2 whereClafun($value)
 * @method static Builder|Repa1l2 whereClaind($value)
 * @method static Builder|Repa1l2 whereCs1($value)
 * @method static Builder|Repa1l2 whereCs2($value)
 * @method static Builder|Repa1l2 whereCs3($value)
 * @method static Builder|Repa1l2 whereDa1($value)
 * @method static Builder|Repa1l2 whereDa2($value)
 * @method static Builder|Repa1l2 whereDescom($value)
 * @method static Builder|Repa1l2 whereEnte($value)
 * @method static Builder|Repa1l2 whereId($value)
 * @method static Builder|Repa1l2 wherePo1($value)
 * @method static Builder|Repa1l2 wherePo2($value)
 * @method static Builder|Repa1l2 wherePronta($value)
 * @method static Builder|Repa1l2 whereRe1($value)
 * @method static Builder|Repa1l2 whereRe2($value)
 * @method static Builder|Repa1l2 whereRepar($value)
 * @method static Builder|Repa1l2 whereSr1($value)
 * @method static Builder|Repa1l2 whereSr2($value)
 * @method static Builder|Repa1l2 whereSstcod($value)
 * @method static Builder|Repa1l2 whereStabi($value)
 * @method static Builder|Repa1l2 whereStrcod($value)
 * @method static Builder|Repa1l2 whereTipcod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repa1l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repa1l2 extends BaseModel
{
    protected $table = 'repa1l2';
}
