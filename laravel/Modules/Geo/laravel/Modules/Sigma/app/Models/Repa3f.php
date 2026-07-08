<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repa3f.
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
 * @property string|null $rdesc
 * @property string|null $rdatai
 * @property string|null $rdataf
 *
 * @method static Builder|Repa3f newModelQuery()
 * @method static Builder|Repa3f newQuery()
 * @method static Builder|Repa3f query()
 * @method static Builder|Repa3f whereAggser($value)
 * @method static Builder|Repa3f whereAggstr($value)
 * @method static Builder|Repa3f whereAggtip($value)
 * @method static Builder|Repa3f whereArtcod($value)
 * @method static Builder|Repa3f whereArttip($value)
 * @method static Builder|Repa3f whereCc1($value)
 * @method static Builder|Repa3f whereCc2($value)
 * @method static Builder|Repa3f whereCc3($value)
 * @method static Builder|Repa3f whereClafun($value)
 * @method static Builder|Repa3f whereClaind($value)
 * @method static Builder|Repa3f whereCs1($value)
 * @method static Builder|Repa3f whereCs2($value)
 * @method static Builder|Repa3f whereCs3($value)
 * @method static Builder|Repa3f whereDa1($value)
 * @method static Builder|Repa3f whereDa2($value)
 * @method static Builder|Repa3f whereDescom($value)
 * @method static Builder|Repa3f whereEnte($value)
 * @method static Builder|Repa3f whereId($value)
 * @method static Builder|Repa3f wherePo1($value)
 * @method static Builder|Repa3f wherePo2($value)
 * @method static Builder|Repa3f wherePronta($value)
 * @method static Builder|Repa3f whereRdataf($value)
 * @method static Builder|Repa3f whereRdatai($value)
 * @method static Builder|Repa3f whereRdesc($value)
 * @method static Builder|Repa3f whereRe1($value)
 * @method static Builder|Repa3f whereRe2($value)
 * @method static Builder|Repa3f whereRepar($value)
 * @method static Builder|Repa3f whereSr1($value)
 * @method static Builder|Repa3f whereSr2($value)
 * @method static Builder|Repa3f whereSstcod($value)
 * @method static Builder|Repa3f whereStabi($value)
 * @method static Builder|Repa3f whereStrcod($value)
 * @method static Builder|Repa3f whereTipcod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repa3fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repa3f extends BaseModel
{
    protected $table = 'repa3f';
}
