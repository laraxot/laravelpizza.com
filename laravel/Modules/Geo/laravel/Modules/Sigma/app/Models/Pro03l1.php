<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Pro03l1.
 *
 * @property int $id
 * @property string|null $p3annu
 * @property string|null $enteap
 * @property string|null $p3dtal
 * @property string|null $p3dtul
 * @property string|null $p3matr
 * @property string|null $p3reco
 * @property string|null $p3ind1
 * @property string|null $p3fld1
 * @property string|null $p3ind2
 * @property string|null $p3fld2
 * @property string|null $p3ind3
 * @property string|null $p3fld3
 * @property string|null $p3ind4
 * @property string|null $p3fld4
 * @property string|null $p3ind5
 * @property string|null $p3fld5
 * @property string|null $p3ind6
 * @property string|null $p3fld6
 * @property string|null $p3ind7
 * @property string|null $p3fld7
 * @property string|null $p3flg1
 * @property string|null $p3flg2
 * @property string|null $p3com1
 * @property string|null $p3com2
 *
 * @method static Builder|Pro03l1 newModelQuery()
 * @method static Builder|Pro03l1 newQuery()
 * @method static Builder|Pro03l1 query()
 * @method static Builder|Pro03l1 whereEnteap($value)
 * @method static Builder|Pro03l1 whereId($value)
 * @method static Builder|Pro03l1 whereP3annu($value)
 * @method static Builder|Pro03l1 whereP3com1($value)
 * @method static Builder|Pro03l1 whereP3com2($value)
 * @method static Builder|Pro03l1 whereP3dtal($value)
 * @method static Builder|Pro03l1 whereP3dtul($value)
 * @method static Builder|Pro03l1 whereP3fld1($value)
 * @method static Builder|Pro03l1 whereP3fld2($value)
 * @method static Builder|Pro03l1 whereP3fld3($value)
 * @method static Builder|Pro03l1 whereP3fld4($value)
 * @method static Builder|Pro03l1 whereP3fld5($value)
 * @method static Builder|Pro03l1 whereP3fld6($value)
 * @method static Builder|Pro03l1 whereP3fld7($value)
 * @method static Builder|Pro03l1 whereP3flg1($value)
 * @method static Builder|Pro03l1 whereP3flg2($value)
 * @method static Builder|Pro03l1 whereP3ind1($value)
 * @method static Builder|Pro03l1 whereP3ind2($value)
 * @method static Builder|Pro03l1 whereP3ind3($value)
 * @method static Builder|Pro03l1 whereP3ind4($value)
 * @method static Builder|Pro03l1 whereP3ind5($value)
 * @method static Builder|Pro03l1 whereP3ind6($value)
 * @method static Builder|Pro03l1 whereP3ind7($value)
 * @method static Builder|Pro03l1 whereP3matr($value)
 * @method static Builder|Pro03l1 whereP3reco($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Pro03l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Pro03l1 extends BaseModel
{
    protected $table = 'pro03l1';
}
