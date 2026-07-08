<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua01k2.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $prvdal
 * @property string|null $prvsca
 * @property string|null $matsos
 * @property string|null $prov1
 * @property string|null $prda1
 * @property string|null $nupr1
 * @property string|null $prov2
 * @property string|null $prda2
 * @property string|null $nupr2
 * @property string|null $prov3
 * @property string|null $prda3
 * @property string|null $nupr3
 * @property string|null $prov4
 * @property string|null $prda4
 * @property string|null $nupr4
 * @property string|null $prov5
 * @property string|null $prda5
 * @property string|null $nupr5
 * @property string|null $flgan
 * @property string|null $prv2kl
 * @property string|null $prv2ks
 * @property string|null $prd2k1
 * @property string|null $prd2k2
 * @property string|null $prd2k3
 * @property string|null $prd2k4
 * @property string|null $prd2k5
 * @property string|null $tipsca
 * @property string|null $qua011
 * @property string|null $qua012
 * @property string|null $qua013
 * @property string|null $qua014
 * @property string|null $qua015
 *
 * @method static Builder|Qua01k2 newModelQuery()
 * @method static Builder|Qua01k2 newQuery()
 * @method static Builder|Qua01k2 query()
 * @method static Builder|Qua01k2 whereEnte($value)
 * @method static Builder|Qua01k2 whereFlgan($value)
 * @method static Builder|Qua01k2 whereId($value)
 * @method static Builder|Qua01k2 whereMatr($value)
 * @method static Builder|Qua01k2 whereMatsos($value)
 * @method static Builder|Qua01k2 whereNupr1($value)
 * @method static Builder|Qua01k2 whereNupr2($value)
 * @method static Builder|Qua01k2 whereNupr3($value)
 * @method static Builder|Qua01k2 whereNupr4($value)
 * @method static Builder|Qua01k2 whereNupr5($value)
 * @method static Builder|Qua01k2 wherePrd2k1($value)
 * @method static Builder|Qua01k2 wherePrd2k2($value)
 * @method static Builder|Qua01k2 wherePrd2k3($value)
 * @method static Builder|Qua01k2 wherePrd2k4($value)
 * @method static Builder|Qua01k2 wherePrd2k5($value)
 * @method static Builder|Qua01k2 wherePrda1($value)
 * @method static Builder|Qua01k2 wherePrda2($value)
 * @method static Builder|Qua01k2 wherePrda3($value)
 * @method static Builder|Qua01k2 wherePrda4($value)
 * @method static Builder|Qua01k2 wherePrda5($value)
 * @method static Builder|Qua01k2 whereProv1($value)
 * @method static Builder|Qua01k2 whereProv2($value)
 * @method static Builder|Qua01k2 whereProv3($value)
 * @method static Builder|Qua01k2 whereProv4($value)
 * @method static Builder|Qua01k2 whereProv5($value)
 * @method static Builder|Qua01k2 wherePrv2kl($value)
 * @method static Builder|Qua01k2 wherePrv2ks($value)
 * @method static Builder|Qua01k2 wherePrvdal($value)
 * @method static Builder|Qua01k2 wherePrvsca($value)
 * @method static Builder|Qua01k2 whereQua011($value)
 * @method static Builder|Qua01k2 whereQua012($value)
 * @method static Builder|Qua01k2 whereQua013($value)
 * @method static Builder|Qua01k2 whereQua014($value)
 * @method static Builder|Qua01k2 whereQua015($value)
 * @method static Builder|Qua01k2 whereTipsca($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua01k2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua01k2 extends BaseModel
{
    protected $table = 'qua01k2';
}
