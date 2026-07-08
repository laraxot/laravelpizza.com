<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Agg00f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $aggaa
 * @property string|null $aggtc
 * @property string|null $mid01
 * @property string|null $mid02
 * @property string|null $mid03
 * @property string|null $mid04
 * @property string|null $mid05
 * @property string|null $mid06
 * @property string|null $mid07
 * @property string|null $mid08
 * @property string|null $mid09
 * @property string|null $mid10
 * @property string|null $mid11
 * @property string|null $mid12
 * @property string|null $mie01
 * @property string|null $mie02
 * @property string|null $mie03
 * @property string|null $mie04
 * @property string|null $mie05
 * @property string|null $mie06
 * @property string|null $mie07
 * @property string|null $mie08
 * @property string|null $mie09
 * @property string|null $mie10
 * @property string|null $mie11
 * @property string|null $mie12
 * @property string|null $tid
 * @property string|null $tie
 * @property string|null $tideu
 * @property string|null $tieeu
 * @property string|null $mld01
 * @property string|null $mld02
 * @property string|null $mld03
 * @property string|null $mld04
 * @property string|null $mld05
 * @property string|null $mld06
 * @property string|null $mld07
 * @property string|null $mld08
 * @property string|null $mld09
 * @property string|null $mld10
 * @property string|null $mld11
 * @property string|null $mld12
 * @property string|null $tld
 * @property string|null $tldeu
 * @property string|null $tmm
 * @property string|null $tle
 * @property string|null $tleeu
 * @property string|null $ted
 * @property string|null $tee
 * @property string|null $tedeu
 * @property string|null $teeeu
 * @property string|null $tcd
 * @property string|null $tce
 * @property string|null $tcdeu
 * @property string|null $tceeu
 *
 * @method static Builder|Agg00f newModelQuery()
 * @method static Builder|Agg00f newQuery()
 * @method static Builder|Agg00f query()
 * @method static Builder|Agg00f whereAggaa($value)
 * @method static Builder|Agg00f whereAggtc($value)
 * @method static Builder|Agg00f whereEnte($value)
 * @method static Builder|Agg00f whereId($value)
 * @method static Builder|Agg00f whereMatr($value)
 * @method static Builder|Agg00f whereMid01($value)
 * @method static Builder|Agg00f whereMid02($value)
 * @method static Builder|Agg00f whereMid03($value)
 * @method static Builder|Agg00f whereMid04($value)
 * @method static Builder|Agg00f whereMid05($value)
 * @method static Builder|Agg00f whereMid06($value)
 * @method static Builder|Agg00f whereMid07($value)
 * @method static Builder|Agg00f whereMid08($value)
 * @method static Builder|Agg00f whereMid09($value)
 * @method static Builder|Agg00f whereMid10($value)
 * @method static Builder|Agg00f whereMid11($value)
 * @method static Builder|Agg00f whereMid12($value)
 * @method static Builder|Agg00f whereMie01($value)
 * @method static Builder|Agg00f whereMie02($value)
 * @method static Builder|Agg00f whereMie03($value)
 * @method static Builder|Agg00f whereMie04($value)
 * @method static Builder|Agg00f whereMie05($value)
 * @method static Builder|Agg00f whereMie06($value)
 * @method static Builder|Agg00f whereMie07($value)
 * @method static Builder|Agg00f whereMie08($value)
 * @method static Builder|Agg00f whereMie09($value)
 * @method static Builder|Agg00f whereMie10($value)
 * @method static Builder|Agg00f whereMie11($value)
 * @method static Builder|Agg00f whereMie12($value)
 * @method static Builder|Agg00f whereMld01($value)
 * @method static Builder|Agg00f whereMld02($value)
 * @method static Builder|Agg00f whereMld03($value)
 * @method static Builder|Agg00f whereMld04($value)
 * @method static Builder|Agg00f whereMld05($value)
 * @method static Builder|Agg00f whereMld06($value)
 * @method static Builder|Agg00f whereMld07($value)
 * @method static Builder|Agg00f whereMld08($value)
 * @method static Builder|Agg00f whereMld09($value)
 * @method static Builder|Agg00f whereMld10($value)
 * @method static Builder|Agg00f whereMld11($value)
 * @method static Builder|Agg00f whereMld12($value)
 * @method static Builder|Agg00f whereTcd($value)
 * @method static Builder|Agg00f whereTcdeu($value)
 * @method static Builder|Agg00f whereTce($value)
 * @method static Builder|Agg00f whereTceeu($value)
 * @method static Builder|Agg00f whereTed($value)
 * @method static Builder|Agg00f whereTedeu($value)
 * @method static Builder|Agg00f whereTee($value)
 * @method static Builder|Agg00f whereTeeeu($value)
 * @method static Builder|Agg00f whereTid($value)
 * @method static Builder|Agg00f whereTideu($value)
 * @method static Builder|Agg00f whereTie($value)
 * @method static Builder|Agg00f whereTieeu($value)
 * @method static Builder|Agg00f whereTld($value)
 * @method static Builder|Agg00f whereTldeu($value)
 * @method static Builder|Agg00f whereTle($value)
 * @method static Builder|Agg00f whereTleeu($value)
 * @method static Builder|Agg00f whereTmm($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Agg00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Agg00f extends BaseModel
{
    protected $table = 'agg00f';
}
