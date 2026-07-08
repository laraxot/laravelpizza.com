<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repa1l1.
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
 * @method static Builder|Repa1l1 newModelQuery()
 * @method static Builder|Repa1l1 newQuery()
 * @method static Builder|Repa1l1 query()
 * @method static Builder|Repa1l1 whereAggser($value)
 * @method static Builder|Repa1l1 whereAggstr($value)
 * @method static Builder|Repa1l1 whereAggtip($value)
 * @method static Builder|Repa1l1 whereArtcod($value)
 * @method static Builder|Repa1l1 whereArttip($value)
 * @method static Builder|Repa1l1 whereCc1($value)
 * @method static Builder|Repa1l1 whereCc2($value)
 * @method static Builder|Repa1l1 whereCc3($value)
 * @method static Builder|Repa1l1 whereClafun($value)
 * @method static Builder|Repa1l1 whereClaind($value)
 * @method static Builder|Repa1l1 whereCs1($value)
 * @method static Builder|Repa1l1 whereCs2($value)
 * @method static Builder|Repa1l1 whereCs3($value)
 * @method static Builder|Repa1l1 whereDa1($value)
 * @method static Builder|Repa1l1 whereDa2($value)
 * @method static Builder|Repa1l1 whereDescom($value)
 * @method static Builder|Repa1l1 whereEnte($value)
 * @method static Builder|Repa1l1 whereId($value)
 * @method static Builder|Repa1l1 wherePo1($value)
 * @method static Builder|Repa1l1 wherePo2($value)
 * @method static Builder|Repa1l1 wherePronta($value)
 * @method static Builder|Repa1l1 whereRe1($value)
 * @method static Builder|Repa1l1 whereRe2($value)
 * @method static Builder|Repa1l1 whereRepar($value)
 * @method static Builder|Repa1l1 whereSr1($value)
 * @method static Builder|Repa1l1 whereSr2($value)
 * @method static Builder|Repa1l1 whereSstcod($value)
 * @method static Builder|Repa1l1 whereStabi($value)
 * @method static Builder|Repa1l1 whereStrcod($value)
 * @method static Builder|Repa1l1 whereTipcod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repa1l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repa1l1 extends BaseModel
{
    protected $table = 'repa1l1';
}
