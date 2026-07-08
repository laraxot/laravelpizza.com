<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Aliqu3l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $assu1
 * @property string|null $dimi1
 * @property string|null $stab
 * @property string|null $repa
 * @property string|null $desst
 * @property string|null $desre
 * @property string|null $q3tipo
 * @property string|null $q3pro
 * @property string|null $q3fun
 * @property string|null $q32kd
 * @property string|null $q32ka
 * @property string|null $pt1q3
 * @property string|null $pt2q3
 * @property string|null $q3desc
 * @property string|null $q3des2
 * @property string|null $q32ka1
 * @property string|null $q32ka2
 * @property string|null $q3003
 * @property string|null $datn1
 * @property string|null $eta
 * @property string|null $sess1
 * @property string|null $codf11
 * @property string|null $gru1
 * @property string|null $con1
 * @property string|null $tip1
 * @property string|null $rap1
 * @property string|null $ruo1
 * @property string|null $pro1
 * @property string|null $pos1
 * @property string|null $man1
 * @property string|null $dis1
 * @property string|null $qu1d
 * @property string|null $qu2d
 * @property string|null $qu3d
 * @property string|null $quli
 * @property string|null $pt1
 * @property string|null $pt2
 *
 * @method static Builder|Aliqu3l1 newModelQuery()
 * @method static Builder|Aliqu3l1 newQuery()
 * @method static Builder|Aliqu3l1 query()
 * @method static Builder|Aliqu3l1 whereAssu1($value)
 * @method static Builder|Aliqu3l1 whereCodf11($value)
 * @method static Builder|Aliqu3l1 whereCon1($value)
 * @method static Builder|Aliqu3l1 whereConome($value)
 * @method static Builder|Aliqu3l1 whereDatn1($value)
 * @method static Builder|Aliqu3l1 whereDesre($value)
 * @method static Builder|Aliqu3l1 whereDesst($value)
 * @method static Builder|Aliqu3l1 whereDimi1($value)
 * @method static Builder|Aliqu3l1 whereDis1($value)
 * @method static Builder|Aliqu3l1 whereEnte($value)
 * @method static Builder|Aliqu3l1 whereEta($value)
 * @method static Builder|Aliqu3l1 whereGru1($value)
 * @method static Builder|Aliqu3l1 whereId($value)
 * @method static Builder|Aliqu3l1 whereMan1($value)
 * @method static Builder|Aliqu3l1 whereMatr($value)
 * @method static Builder|Aliqu3l1 whereNome($value)
 * @method static Builder|Aliqu3l1 wherePos1($value)
 * @method static Builder|Aliqu3l1 wherePro1($value)
 * @method static Builder|Aliqu3l1 wherePt1($value)
 * @method static Builder|Aliqu3l1 wherePt1q3($value)
 * @method static Builder|Aliqu3l1 wherePt2($value)
 * @method static Builder|Aliqu3l1 wherePt2q3($value)
 * @method static Builder|Aliqu3l1 whereQ3003($value)
 * @method static Builder|Aliqu3l1 whereQ32ka($value)
 * @method static Builder|Aliqu3l1 whereQ32ka1($value)
 * @method static Builder|Aliqu3l1 whereQ32ka2($value)
 * @method static Builder|Aliqu3l1 whereQ32kd($value)
 * @method static Builder|Aliqu3l1 whereQ3des2($value)
 * @method static Builder|Aliqu3l1 whereQ3desc($value)
 * @method static Builder|Aliqu3l1 whereQ3fun($value)
 * @method static Builder|Aliqu3l1 whereQ3pro($value)
 * @method static Builder|Aliqu3l1 whereQ3tipo($value)
 * @method static Builder|Aliqu3l1 whereQu1d($value)
 * @method static Builder|Aliqu3l1 whereQu2d($value)
 * @method static Builder|Aliqu3l1 whereQu3d($value)
 * @method static Builder|Aliqu3l1 whereQuli($value)
 * @method static Builder|Aliqu3l1 whereRap1($value)
 * @method static Builder|Aliqu3l1 whereRepa($value)
 * @method static Builder|Aliqu3l1 whereRuo1($value)
 * @method static Builder|Aliqu3l1 whereSess1($value)
 * @method static Builder|Aliqu3l1 whereStab($value)
 * @method static Builder|Aliqu3l1 whereTip1($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Aliqu3l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Aliqu3l1 extends BaseModel
{
    protected $table = 'aliqu3l1';
}
