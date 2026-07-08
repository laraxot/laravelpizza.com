<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wrim03l1.
 *
 * @property int $id
 * @property string|null $r3annu
 * @property string|null $enteap
 * @property string|null $stdata
 * @property string|null $r3matr
 * @property string|null $r3reco
 * @property string|null $r3ind1
 * @property string|null $r3fld1
 * @property string|null $r3ind2
 * @property string|null $r3fld2
 * @property string|null $r3ind3
 * @property string|null $r3fld3
 * @property string|null $r3ind4
 * @property string|null $r3fld4
 * @property string|null $r3ind5
 * @property string|null $r3fld5
 * @property string|null $r3ind6
 * @property string|null $r3fld6
 * @property string|null $r3ind7
 * @property string|null $r3fld7
 * @property string|null $r3flg1
 * @property string|null $r3flg2
 * @property string|null $r3com1
 * @property string|null $r3com2
 *
 * @method static Builder|Wrim03l1 newModelQuery()
 * @method static Builder|Wrim03l1 newQuery()
 * @method static Builder|Wrim03l1 query()
 * @method static Builder|Wrim03l1 whereEnteap($value)
 * @method static Builder|Wrim03l1 whereId($value)
 * @method static Builder|Wrim03l1 whereR3annu($value)
 * @method static Builder|Wrim03l1 whereR3com1($value)
 * @method static Builder|Wrim03l1 whereR3com2($value)
 * @method static Builder|Wrim03l1 whereR3fld1($value)
 * @method static Builder|Wrim03l1 whereR3fld2($value)
 * @method static Builder|Wrim03l1 whereR3fld3($value)
 * @method static Builder|Wrim03l1 whereR3fld4($value)
 * @method static Builder|Wrim03l1 whereR3fld5($value)
 * @method static Builder|Wrim03l1 whereR3fld6($value)
 * @method static Builder|Wrim03l1 whereR3fld7($value)
 * @method static Builder|Wrim03l1 whereR3flg1($value)
 * @method static Builder|Wrim03l1 whereR3flg2($value)
 * @method static Builder|Wrim03l1 whereR3ind1($value)
 * @method static Builder|Wrim03l1 whereR3ind2($value)
 * @method static Builder|Wrim03l1 whereR3ind3($value)
 * @method static Builder|Wrim03l1 whereR3ind4($value)
 * @method static Builder|Wrim03l1 whereR3ind5($value)
 * @method static Builder|Wrim03l1 whereR3ind6($value)
 * @method static Builder|Wrim03l1 whereR3ind7($value)
 * @method static Builder|Wrim03l1 whereR3matr($value)
 * @method static Builder|Wrim03l1 whereR3reco($value)
 * @method static Builder|Wrim03l1 whereStdata($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wrim03l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wrim03l1 extends BaseModel
{
    protected $table = 'wrim03l1';
}
