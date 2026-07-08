<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua01f.
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
 * @method static Builder|Qua01f newModelQuery()
 * @method static Builder|Qua01f newQuery()
 * @method static Builder|Qua01f query()
 * @method static Builder|Qua01f whereEnte($value)
 * @method static Builder|Qua01f whereFlgan($value)
 * @method static Builder|Qua01f whereId($value)
 * @method static Builder|Qua01f whereMatr($value)
 * @method static Builder|Qua01f whereMatsos($value)
 * @method static Builder|Qua01f whereNupr1($value)
 * @method static Builder|Qua01f whereNupr2($value)
 * @method static Builder|Qua01f whereNupr3($value)
 * @method static Builder|Qua01f whereNupr4($value)
 * @method static Builder|Qua01f whereNupr5($value)
 * @method static Builder|Qua01f wherePrd2k1($value)
 * @method static Builder|Qua01f wherePrd2k2($value)
 * @method static Builder|Qua01f wherePrd2k3($value)
 * @method static Builder|Qua01f wherePrd2k4($value)
 * @method static Builder|Qua01f wherePrd2k5($value)
 * @method static Builder|Qua01f wherePrda1($value)
 * @method static Builder|Qua01f wherePrda2($value)
 * @method static Builder|Qua01f wherePrda3($value)
 * @method static Builder|Qua01f wherePrda4($value)
 * @method static Builder|Qua01f wherePrda5($value)
 * @method static Builder|Qua01f whereProv1($value)
 * @method static Builder|Qua01f whereProv2($value)
 * @method static Builder|Qua01f whereProv3($value)
 * @method static Builder|Qua01f whereProv4($value)
 * @method static Builder|Qua01f whereProv5($value)
 * @method static Builder|Qua01f wherePrv2kl($value)
 * @method static Builder|Qua01f wherePrv2ks($value)
 * @method static Builder|Qua01f wherePrvdal($value)
 * @method static Builder|Qua01f wherePrvsca($value)
 * @method static Builder|Qua01f whereQua011($value)
 * @method static Builder|Qua01f whereQua012($value)
 * @method static Builder|Qua01f whereQua013($value)
 * @method static Builder|Qua01f whereQua014($value)
 * @method static Builder|Qua01f whereQua015($value)
 * @method static Builder|Qua01f whereTipsca($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua01f extends BaseModel
{
    protected $table = 'qua01f';
}
