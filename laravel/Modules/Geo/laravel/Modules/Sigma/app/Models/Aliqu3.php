<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Aliqu3.
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
 * @method static Builder|Aliqu3 newModelQuery()
 * @method static Builder|Aliqu3 newQuery()
 * @method static Builder|Aliqu3 query()
 * @method static Builder|Aliqu3 whereAssu1($value)
 * @method static Builder|Aliqu3 whereCodf11($value)
 * @method static Builder|Aliqu3 whereCon1($value)
 * @method static Builder|Aliqu3 whereConome($value)
 * @method static Builder|Aliqu3 whereDatn1($value)
 * @method static Builder|Aliqu3 whereDesre($value)
 * @method static Builder|Aliqu3 whereDesst($value)
 * @method static Builder|Aliqu3 whereDimi1($value)
 * @method static Builder|Aliqu3 whereDis1($value)
 * @method static Builder|Aliqu3 whereEnte($value)
 * @method static Builder|Aliqu3 whereEta($value)
 * @method static Builder|Aliqu3 whereGru1($value)
 * @method static Builder|Aliqu3 whereId($value)
 * @method static Builder|Aliqu3 whereMan1($value)
 * @method static Builder|Aliqu3 whereMatr($value)
 * @method static Builder|Aliqu3 whereNome($value)
 * @method static Builder|Aliqu3 wherePos1($value)
 * @method static Builder|Aliqu3 wherePro1($value)
 * @method static Builder|Aliqu3 wherePt1($value)
 * @method static Builder|Aliqu3 wherePt1q3($value)
 * @method static Builder|Aliqu3 wherePt2($value)
 * @method static Builder|Aliqu3 wherePt2q3($value)
 * @method static Builder|Aliqu3 whereQ3003($value)
 * @method static Builder|Aliqu3 whereQ32ka($value)
 * @method static Builder|Aliqu3 whereQ32ka1($value)
 * @method static Builder|Aliqu3 whereQ32ka2($value)
 * @method static Builder|Aliqu3 whereQ32kd($value)
 * @method static Builder|Aliqu3 whereQ3des2($value)
 * @method static Builder|Aliqu3 whereQ3desc($value)
 * @method static Builder|Aliqu3 whereQ3fun($value)
 * @method static Builder|Aliqu3 whereQ3pro($value)
 * @method static Builder|Aliqu3 whereQ3tipo($value)
 * @method static Builder|Aliqu3 whereQu1d($value)
 * @method static Builder|Aliqu3 whereQu2d($value)
 * @method static Builder|Aliqu3 whereQu3d($value)
 * @method static Builder|Aliqu3 whereQuli($value)
 * @method static Builder|Aliqu3 whereRap1($value)
 * @method static Builder|Aliqu3 whereRepa($value)
 * @method static Builder|Aliqu3 whereRuo1($value)
 * @method static Builder|Aliqu3 whereSess1($value)
 * @method static Builder|Aliqu3 whereStab($value)
 * @method static Builder|Aliqu3 whereTip1($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Aliqu3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Aliqu3 extends BaseModel
{
    protected $table = 'aliqu3';
}
