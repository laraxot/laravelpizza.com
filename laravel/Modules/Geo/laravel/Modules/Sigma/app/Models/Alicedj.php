<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Alicedj.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $annor
 * @property int|null $meser
 * @property string|null $conome
 * @property string|null $nome
 * @property int|null $con
 * @property int|null $tip
 * @property int|null $rap
 * @property int|null $ruo
 * @property int|null $pro
 * @property int|null $pos
 * @property int|null $man
 * @property int|null $dis
 * @property string|null $prod
 * @property string|null $qu1d
 * @property string|null $qu2d
 * @property string|null $quli
 * @property int|null $matina
 * @property string|null $codfis
 * @property int|null $repst2
 * @property int|null $repre2
 * @property string|null $desst
 * @property string|null $desre
 * @property string|null $pt1
 * @property string|null $pt2
 * @property int|null $assunz
 * @property int|null $dimiss
 * @property string|null $v1
 * @property string|null $q1
 * @property string|null $v2
 * @property string|null $q2
 * @property string|null $v3
 * @property string|null $q3
 * @property string|null $v4
 * @property string|null $q4
 * @property string|null $v5
 * @property string|null $q5
 * @property string|null $v6
 * @property string|null $q6
 * @property string|null $v7
 * @property string|null $q7
 * @property string|null $v8
 * @property string|null $q8
 * @property string|null $v9
 * @property string|null $q9
 * @property string|null $v10
 * @property string|null $q10
 * @property string|null $v11
 * @property string|null $q11
 * @property string|null $v12
 * @property string|null $q12
 * @property string|null $v13
 * @property string|null $q13
 * @property string|null $v14
 * @property string|null $q14
 * @property string|null $v15
 * @property string|null $q15
 * @property string|null $v16
 * @property string|null $q16
 * @property string|null $tot670
 * @property string|null $tot679
 *
 * @method static Builder|Alicedj newModelQuery()
 * @method static Builder|Alicedj newQuery()
 * @method static Builder|Alicedj query()
 * @method static Builder|Alicedj whereAnnor($value)
 * @method static Builder|Alicedj whereAssunz($value)
 * @method static Builder|Alicedj whereCodfis($value)
 * @method static Builder|Alicedj whereCon($value)
 * @method static Builder|Alicedj whereConome($value)
 * @method static Builder|Alicedj whereDesre($value)
 * @method static Builder|Alicedj whereDesst($value)
 * @method static Builder|Alicedj whereDimiss($value)
 * @method static Builder|Alicedj whereDis($value)
 * @method static Builder|Alicedj whereEnte($value)
 * @method static Builder|Alicedj whereId($value)
 * @method static Builder|Alicedj whereMan($value)
 * @method static Builder|Alicedj whereMatina($value)
 * @method static Builder|Alicedj whereMatr($value)
 * @method static Builder|Alicedj whereMeser($value)
 * @method static Builder|Alicedj whereNome($value)
 * @method static Builder|Alicedj wherePos($value)
 * @method static Builder|Alicedj wherePro($value)
 * @method static Builder|Alicedj whereProd($value)
 * @method static Builder|Alicedj wherePt1($value)
 * @method static Builder|Alicedj wherePt2($value)
 * @method static Builder|Alicedj whereQ1($value)
 * @method static Builder|Alicedj whereQ10($value)
 * @method static Builder|Alicedj whereQ11($value)
 * @method static Builder|Alicedj whereQ12($value)
 * @method static Builder|Alicedj whereQ13($value)
 * @method static Builder|Alicedj whereQ14($value)
 * @method static Builder|Alicedj whereQ15($value)
 * @method static Builder|Alicedj whereQ16($value)
 * @method static Builder|Alicedj whereQ2($value)
 * @method static Builder|Alicedj whereQ3($value)
 * @method static Builder|Alicedj whereQ4($value)
 * @method static Builder|Alicedj whereQ5($value)
 * @method static Builder|Alicedj whereQ6($value)
 * @method static Builder|Alicedj whereQ7($value)
 * @method static Builder|Alicedj whereQ8($value)
 * @method static Builder|Alicedj whereQ9($value)
 * @method static Builder|Alicedj whereQu1d($value)
 * @method static Builder|Alicedj whereQu2d($value)
 * @method static Builder|Alicedj whereQuli($value)
 * @method static Builder|Alicedj whereRap($value)
 * @method static Builder|Alicedj whereRepre2($value)
 * @method static Builder|Alicedj whereRepst2($value)
 * @method static Builder|Alicedj whereRuo($value)
 * @method static Builder|Alicedj whereTip($value)
 * @method static Builder|Alicedj whereTot670($value)
 * @method static Builder|Alicedj whereTot679($value)
 * @method static Builder|Alicedj whereV1($value)
 * @method static Builder|Alicedj whereV10($value)
 * @method static Builder|Alicedj whereV11($value)
 * @method static Builder|Alicedj whereV12($value)
 * @method static Builder|Alicedj whereV13($value)
 * @method static Builder|Alicedj whereV14($value)
 * @method static Builder|Alicedj whereV15($value)
 * @method static Builder|Alicedj whereV16($value)
 * @method static Builder|Alicedj whereV2($value)
 * @method static Builder|Alicedj whereV3($value)
 * @method static Builder|Alicedj whereV4($value)
 * @method static Builder|Alicedj whereV5($value)
 * @method static Builder|Alicedj whereV6($value)
 * @method static Builder|Alicedj whereV7($value)
 * @method static Builder|Alicedj whereV8($value)
 * @method static Builder|Alicedj whereV9($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AlicedjFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Alicedj extends BaseModel
{
    protected $table = 'alicedj';
}
