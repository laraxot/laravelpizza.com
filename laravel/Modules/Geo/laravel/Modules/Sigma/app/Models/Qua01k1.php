<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua01k1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $prvdal
 * @property int|null $prvsca
 * @property int|null $matsos
 * @property int|null $prov1
 * @property int|null $prda1
 * @property string|null $nupr1
 * @property int|null $prov2
 * @property int|null $prda2
 * @property string|null $nupr2
 * @property int|null $prov3
 * @property int|null $prda3
 * @property string|null $nupr3
 * @property int|null $prov4
 * @property int|null $prda4
 * @property string|null $nupr4
 * @property int|null $prov5
 * @property int|null $prda5
 * @property string|null $nupr5
 * @property string|null $flgan
 * @property int|null $prv2kl
 * @property int|null $prv2ks
 * @property int|null $prd2k1
 * @property int|null $prd2k2
 * @property int|null $prd2k3
 * @property int|null $prd2k4
 * @property int|null $prd2k5
 * @property int|null $tipsca
 * @property int|null $qua011
 * @property string|null $qua012
 * @property string|null $qua013
 * @property int|null $qua014
 * @property int|null $qua015
 *
 * @method static Builder|Qua01k1 newModelQuery()
 * @method static Builder|Qua01k1 newQuery()
 * @method static Builder|Qua01k1 query()
 * @method static Builder|Qua01k1 whereEnte($value)
 * @method static Builder|Qua01k1 whereFlgan($value)
 * @method static Builder|Qua01k1 whereId($value)
 * @method static Builder|Qua01k1 whereMatr($value)
 * @method static Builder|Qua01k1 whereMatsos($value)
 * @method static Builder|Qua01k1 whereNupr1($value)
 * @method static Builder|Qua01k1 whereNupr2($value)
 * @method static Builder|Qua01k1 whereNupr3($value)
 * @method static Builder|Qua01k1 whereNupr4($value)
 * @method static Builder|Qua01k1 whereNupr5($value)
 * @method static Builder|Qua01k1 wherePrd2k1($value)
 * @method static Builder|Qua01k1 wherePrd2k2($value)
 * @method static Builder|Qua01k1 wherePrd2k3($value)
 * @method static Builder|Qua01k1 wherePrd2k4($value)
 * @method static Builder|Qua01k1 wherePrd2k5($value)
 * @method static Builder|Qua01k1 wherePrda1($value)
 * @method static Builder|Qua01k1 wherePrda2($value)
 * @method static Builder|Qua01k1 wherePrda3($value)
 * @method static Builder|Qua01k1 wherePrda4($value)
 * @method static Builder|Qua01k1 wherePrda5($value)
 * @method static Builder|Qua01k1 whereProv1($value)
 * @method static Builder|Qua01k1 whereProv2($value)
 * @method static Builder|Qua01k1 whereProv3($value)
 * @method static Builder|Qua01k1 whereProv4($value)
 * @method static Builder|Qua01k1 whereProv5($value)
 * @method static Builder|Qua01k1 wherePrv2kl($value)
 * @method static Builder|Qua01k1 wherePrv2ks($value)
 * @method static Builder|Qua01k1 wherePrvdal($value)
 * @method static Builder|Qua01k1 wherePrvsca($value)
 * @method static Builder|Qua01k1 whereQua011($value)
 * @method static Builder|Qua01k1 whereQua012($value)
 * @method static Builder|Qua01k1 whereQua013($value)
 * @method static Builder|Qua01k1 whereQua014($value)
 * @method static Builder|Qua01k1 whereQua015($value)
 * @method static Builder|Qua01k1 whereTipsca($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua01k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua01k1 extends BaseModel
{
    protected $table = 'qua01k1';
}
