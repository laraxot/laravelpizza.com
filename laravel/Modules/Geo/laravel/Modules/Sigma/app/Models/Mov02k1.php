<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mov02k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $mo2tip
 * @property string|null $mo2cod
 * @property string|null $mo2aa
 * @property string|null $mo2m01
 * @property string|null $mo2m02
 * @property string|null $mo2m03
 * @property string|null $mo2m04
 * @property string|null $mo2m05
 * @property string|null $mo2m06
 * @property string|null $mo2m07
 * @property string|null $mo2m08
 * @property string|null $mo2m09
 * @property string|null $mo2m10
 * @property string|null $mo2m11
 * @property string|null $mo2m12
 * @property string|null $mo2um
 * @property string|null $mo2v01
 * @property string|null $mo2v02
 * @property string|null $mo2v03
 * @property string|null $mo2v04
 * @property string|null $mo2v05
 * @property string|null $mo2v06
 * @property string|null $mo2v07
 * @property string|null $mo2v08
 * @property string|null $mo2v09
 * @property string|null $mo2v10
 * @property string|null $mo2v11
 * @property string|null $mo2v12
 * @property string|null $mo2ann
 * @property string|null $mo22kn
 * @property string|null $mo22kz
 * @property string|null $mo2001
 * @property string|null $mo2002
 * @property string|null $mo2003
 * @property string|null $mo2004
 * @property string|null $mo2005
 *
 * @method static Builder|Mov02k1 newModelQuery()
 * @method static Builder|Mov02k1 newQuery()
 * @method static Builder|Mov02k1 query()
 * @method static Builder|Mov02k1 whereEnte($value)
 * @method static Builder|Mov02k1 whereId($value)
 * @method static Builder|Mov02k1 whereMatr($value)
 * @method static Builder|Mov02k1 whereMo2001($value)
 * @method static Builder|Mov02k1 whereMo2002($value)
 * @method static Builder|Mov02k1 whereMo2003($value)
 * @method static Builder|Mov02k1 whereMo2004($value)
 * @method static Builder|Mov02k1 whereMo2005($value)
 * @method static Builder|Mov02k1 whereMo22kn($value)
 * @method static Builder|Mov02k1 whereMo22kz($value)
 * @method static Builder|Mov02k1 whereMo2aa($value)
 * @method static Builder|Mov02k1 whereMo2ann($value)
 * @method static Builder|Mov02k1 whereMo2cod($value)
 * @method static Builder|Mov02k1 whereMo2m01($value)
 * @method static Builder|Mov02k1 whereMo2m02($value)
 * @method static Builder|Mov02k1 whereMo2m03($value)
 * @method static Builder|Mov02k1 whereMo2m04($value)
 * @method static Builder|Mov02k1 whereMo2m05($value)
 * @method static Builder|Mov02k1 whereMo2m06($value)
 * @method static Builder|Mov02k1 whereMo2m07($value)
 * @method static Builder|Mov02k1 whereMo2m08($value)
 * @method static Builder|Mov02k1 whereMo2m09($value)
 * @method static Builder|Mov02k1 whereMo2m10($value)
 * @method static Builder|Mov02k1 whereMo2m11($value)
 * @method static Builder|Mov02k1 whereMo2m12($value)
 * @method static Builder|Mov02k1 whereMo2tip($value)
 * @method static Builder|Mov02k1 whereMo2um($value)
 * @method static Builder|Mov02k1 whereMo2v01($value)
 * @method static Builder|Mov02k1 whereMo2v02($value)
 * @method static Builder|Mov02k1 whereMo2v03($value)
 * @method static Builder|Mov02k1 whereMo2v04($value)
 * @method static Builder|Mov02k1 whereMo2v05($value)
 * @method static Builder|Mov02k1 whereMo2v06($value)
 * @method static Builder|Mov02k1 whereMo2v07($value)
 * @method static Builder|Mov02k1 whereMo2v08($value)
 * @method static Builder|Mov02k1 whereMo2v09($value)
 * @method static Builder|Mov02k1 whereMo2v10($value)
 * @method static Builder|Mov02k1 whereMo2v11($value)
 * @method static Builder|Mov02k1 whereMo2v12($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mov02k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mov02k1 extends BaseModel
{
    protected $table = 'mov02k1';
}
