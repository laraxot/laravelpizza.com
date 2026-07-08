<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Agg01f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $aggaa
 * @property string|null $aggtc
 * @property string|null $aid01
 * @property string|null $aid02
 * @property string|null $aid03
 * @property string|null $aid04
 * @property string|null $aid05
 * @property string|null $aid06
 * @property string|null $aid07
 * @property string|null $aid08
 * @property string|null $aid09
 * @property string|null $aid10
 * @property string|null $aid11
 * @property string|null $aid12
 * @property string|null $aie01
 * @property string|null $aie02
 * @property string|null $aie03
 * @property string|null $aie04
 * @property string|null $aie05
 * @property string|null $aie06
 * @property string|null $aie07
 * @property string|null $aie08
 * @property string|null $aie09
 * @property string|null $aie10
 * @property string|null $aie11
 * @property string|null $aie12
 * @property string|null $aid
 * @property string|null $aie
 * @property string|null $aideu
 * @property string|null $aieeu
 * @property string|null $ald01
 * @property string|null $ald02
 * @property string|null $ald03
 * @property string|null $ald04
 * @property string|null $ald05
 * @property string|null $ald06
 * @property string|null $ald07
 * @property string|null $ald08
 * @property string|null $ald09
 * @property string|null $ald10
 * @property string|null $ald11
 * @property string|null $ald12
 * @property string|null $ald
 * @property string|null $aldeu
 * @property string|null $amm
 * @property string|null $ale
 * @property string|null $aleeu
 * @property string|null $aed
 * @property string|null $aee
 * @property string|null $aedeu
 * @property string|null $aeeeu
 * @property string|null $acd
 * @property string|null $ace
 * @property string|null $acdeu
 * @property string|null $aceeu
 *
 * @method static Builder|Agg01f newModelQuery()
 * @method static Builder|Agg01f newQuery()
 * @method static Builder|Agg01f query()
 * @method static Builder|Agg01f whereAcd($value)
 * @method static Builder|Agg01f whereAcdeu($value)
 * @method static Builder|Agg01f whereAce($value)
 * @method static Builder|Agg01f whereAceeu($value)
 * @method static Builder|Agg01f whereAed($value)
 * @method static Builder|Agg01f whereAedeu($value)
 * @method static Builder|Agg01f whereAee($value)
 * @method static Builder|Agg01f whereAeeeu($value)
 * @method static Builder|Agg01f whereAggaa($value)
 * @method static Builder|Agg01f whereAggtc($value)
 * @method static Builder|Agg01f whereAid($value)
 * @method static Builder|Agg01f whereAid01($value)
 * @method static Builder|Agg01f whereAid02($value)
 * @method static Builder|Agg01f whereAid03($value)
 * @method static Builder|Agg01f whereAid04($value)
 * @method static Builder|Agg01f whereAid05($value)
 * @method static Builder|Agg01f whereAid06($value)
 * @method static Builder|Agg01f whereAid07($value)
 * @method static Builder|Agg01f whereAid08($value)
 * @method static Builder|Agg01f whereAid09($value)
 * @method static Builder|Agg01f whereAid10($value)
 * @method static Builder|Agg01f whereAid11($value)
 * @method static Builder|Agg01f whereAid12($value)
 * @method static Builder|Agg01f whereAideu($value)
 * @method static Builder|Agg01f whereAie($value)
 * @method static Builder|Agg01f whereAie01($value)
 * @method static Builder|Agg01f whereAie02($value)
 * @method static Builder|Agg01f whereAie03($value)
 * @method static Builder|Agg01f whereAie04($value)
 * @method static Builder|Agg01f whereAie05($value)
 * @method static Builder|Agg01f whereAie06($value)
 * @method static Builder|Agg01f whereAie07($value)
 * @method static Builder|Agg01f whereAie08($value)
 * @method static Builder|Agg01f whereAie09($value)
 * @method static Builder|Agg01f whereAie10($value)
 * @method static Builder|Agg01f whereAie11($value)
 * @method static Builder|Agg01f whereAie12($value)
 * @method static Builder|Agg01f whereAieeu($value)
 * @method static Builder|Agg01f whereAld($value)
 * @method static Builder|Agg01f whereAld01($value)
 * @method static Builder|Agg01f whereAld02($value)
 * @method static Builder|Agg01f whereAld03($value)
 * @method static Builder|Agg01f whereAld04($value)
 * @method static Builder|Agg01f whereAld05($value)
 * @method static Builder|Agg01f whereAld06($value)
 * @method static Builder|Agg01f whereAld07($value)
 * @method static Builder|Agg01f whereAld08($value)
 * @method static Builder|Agg01f whereAld09($value)
 * @method static Builder|Agg01f whereAld10($value)
 * @method static Builder|Agg01f whereAld11($value)
 * @method static Builder|Agg01f whereAld12($value)
 * @method static Builder|Agg01f whereAldeu($value)
 * @method static Builder|Agg01f whereAle($value)
 * @method static Builder|Agg01f whereAleeu($value)
 * @method static Builder|Agg01f whereAmm($value)
 * @method static Builder|Agg01f whereEnte($value)
 * @method static Builder|Agg01f whereId($value)
 * @method static Builder|Agg01f whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Agg01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Agg01f extends BaseModel
{
    protected $table = 'agg01f';
}
