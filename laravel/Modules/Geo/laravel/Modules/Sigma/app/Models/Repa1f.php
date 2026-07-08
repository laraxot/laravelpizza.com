<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repa1f.
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
 * @method static Builder|Repa1f newModelQuery()
 * @method static Builder|Repa1f newQuery()
 * @method static Builder|Repa1f query()
 * @method static Builder|Repa1f whereAggser($value)
 * @method static Builder|Repa1f whereAggstr($value)
 * @method static Builder|Repa1f whereAggtip($value)
 * @method static Builder|Repa1f whereArtcod($value)
 * @method static Builder|Repa1f whereArttip($value)
 * @method static Builder|Repa1f whereCc1($value)
 * @method static Builder|Repa1f whereCc2($value)
 * @method static Builder|Repa1f whereCc3($value)
 * @method static Builder|Repa1f whereClafun($value)
 * @method static Builder|Repa1f whereClaind($value)
 * @method static Builder|Repa1f whereCs1($value)
 * @method static Builder|Repa1f whereCs2($value)
 * @method static Builder|Repa1f whereCs3($value)
 * @method static Builder|Repa1f whereDa1($value)
 * @method static Builder|Repa1f whereDa2($value)
 * @method static Builder|Repa1f whereDescom($value)
 * @method static Builder|Repa1f whereEnte($value)
 * @method static Builder|Repa1f whereId($value)
 * @method static Builder|Repa1f wherePo1($value)
 * @method static Builder|Repa1f wherePo2($value)
 * @method static Builder|Repa1f wherePronta($value)
 * @method static Builder|Repa1f whereRe1($value)
 * @method static Builder|Repa1f whereRe2($value)
 * @method static Builder|Repa1f whereRepar($value)
 * @method static Builder|Repa1f whereSr1($value)
 * @method static Builder|Repa1f whereSr2($value)
 * @method static Builder|Repa1f whereSstcod($value)
 * @method static Builder|Repa1f whereStabi($value)
 * @method static Builder|Repa1f whereStrcod($value)
 * @method static Builder|Repa1f whereTipcod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repa1fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repa1f extends BaseModel
{
    protected $table = 'repa1f';
}
